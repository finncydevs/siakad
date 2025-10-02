<?php

namespace App\Http\Controllers\Admin\Kepegawaian;

use App\Models\Gtk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class GtkController extends Controller
{
    /**
     * Menampilkan daftar Guru.
     */
    public function indexGuru(Request $request)
    {
        $query = Gtk::query()->where('jenis_ptk_id_str', 'Guru');

        $query->when($request->search, function ($q, $search) {
            return $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        });

        $gurus = $query->latest()->paginate(15);
        
        return view('admin.kepegawaian.gtk.index_guru', compact('gurus'));
    }

    /**
     * Menampilkan daftar Tenaga Kependidikan.
     */
    public function indexTendik(Request $request)
    {
        $query = Gtk::query()->where('jenis_ptk_id_str', 'Tenaga Kependidikan');
        
        $query->when($request->search, function ($q, $search) {
            return $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        });

        $tendiks = $query->latest()->paginate(15);
        
        return view('admin.kepegawaian.gtk.index_tendik', compact('tendiks'));
    }

    /**
     * Menampilkan detail untuk satu atau lebih GTK yang dipilih.
     */
    public function showMultiple(Request $request)
    {
        $request->validate(['ids' => 'required|string']);
        
        $ids = explode(',', $request->input('ids'));

        $gtks = Gtk::whereIn('id', $ids)->get();

        return view('admin.kepegawaian.gtk.show_multiple', compact('gtks'));
    }

    /**
     * Menangani export data Guru ke Excel.
     */
    public function exportGuruExcel(Request $request)
    {
        $query = Gtk::query()->where('jenis_ptk_id_str', 'Guru');
        return $this->generateExport($request, $query, 'Data_Guru_Sekull.csv');
    }

    /**
     * Menangani export data Tenaga Kependidikan ke Excel.
     */
    public function exportTendikExcel(Request $request)
    {
        $query = Gtk::query()->where('jenis_ptk_id_str', 'Tenaga Kependidikan');
        return $this->generateExport($request, $query, 'Data_Tendik_Sekull.csv');
    }

    /**
     * Logika utama untuk generate file CSV.
     */
    private function generateExport(Request $request, $query, $fileName)
    {
        // Filter berdasarkan ID yang dipilih
        if ($request->has('ids')) {
            $ids = explode(',', $request->input('ids'));
            $query->whereIn('id', $ids);
        }
        // Filter berdasarkan pencarian yang sedang aktif
        elseif ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        $gtks = $query->latest()->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($gtks) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, [
                'Nama Lengkap', 'Jenis Kelamin', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'NIK',
                'Status Kepegawaian', 'NIP', 'NUPTK', 'Jenis PTK', 'Jabatan', 'Tanggal Surat Tugas', 'Status Induk',
                'Pendidikan Terakhir', 'Bidang Studi Terakhir', 'Pangkat/Golongan Terakhir',
                'Riwayat Pendidikan Formal', 'Riwayat Kepangkatan'
            ]);

            foreach ($gtks as $gtk) {
                fputcsv($file, [
                    $gtk->nama, $gtk->jenis_kelamin, $gtk->tempat_lahir, $gtk->tanggal_lahir,
                    $gtk->agama_id_str, $gtk->nik, $gtk->status_kepegawaian_id_str, $gtk->nip,
                    $gtk->nuptk, $gtk->jenis_ptk_id_str, $gtk->jabatan_ptk_id_str, $gtk->tanggal_surat_tugas,
                    $gtk->ptk_induk == 1 ? 'Induk' : 'Non-Induk', $gtk->pendidikan_terakhir,
                    $gtk->bidang_studi_terakhir, $gtk->pangkat_golongan_terakhir,
                    $gtk->rwy_pend_formal, $gtk->rwy_kepangkatan
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

