<?php

namespace App\Http\Controllers\Admin\Indisipliner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Gtk;
use App\Models\PelanggaranKategoriGtk;
use App\Models\PelanggaranPoinGtk;
use App\Models\PelanggaranSanksiGtk;
use App\Models\PelanggaranNilaiGtk;
use App\Models\Rombel;

class IndisiplinerGtkController extends Controller
{
    // ============================================================
    // PENGATURAN
    // ============================================================
    public function pengaturanIndex()
    {
        $kategoriList = PelanggaranKategoriGtk::with('pelanggaranPoinGtk')
            ->orderBy('nama', 'asc')
            ->get();

        $sanksiList = PelanggaranSanksiGtk::orderBy('poin_min', 'asc')->get();

        return view('admin.indisipliner.guru.pengaturan.index', compact('kategoriList', 'sanksiList'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:pelanggaran_kategori_gtk,nama'
        ]);

        PelanggaranKategoriGtk::create([
            'nama' => strtoupper($request->nama),
            'status' => 1
        ]);

        return back()->with('success', 'Kategori pelanggaran berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, PelanggaranKategoriGtk $kategori)
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pelanggaran_kategori_gtk')->ignore($kategori->ID, 'ID'),
            ],
        ]);

        $kategori->update(['nama' => strtoupper($request->nama)]);
        return back()->with('success', 'Kategori pelanggaran berhasil diperbarui.');
    }

    public function destroyKategori(PelanggaranKategoriGtk $kategori)
    {
        if ($kategori->pelanggaranPoinGtk()->exists()) {
            return back()->withErrors('Kategori tidak dapat dihapus karena masih memiliki jenis pelanggaran.');
        }
        $kategori->delete();
        return back()->with('success', 'Kategori pelanggaran berhasil dihapus.');
    }

    // ============================================================
    // PENGATURAN POIN
    // ============================================================
    public function storePoin(Request $request)
    {
        $request->validate([
            'IDpelanggaran_kategori' => 'required|exists:pelanggaran_kategori_gtk,ID',
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer',
            'tindakan' => 'nullable|string',
        ]);

        PelanggaranPoinGtk::create([
            'IDpelanggaran_kategori' => $request->IDpelanggaran_kategori,
            'nama' => strtoupper($request->nama),
            'poin' => $request->poin,
            'tindakan' => $request->tindakan,
        ]);

        return back()->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function updatePoin(Request $request, $id)
    {
        $request->validate([
            'IDpelanggaran_kategori' => 'required|exists:pelanggaran_kategori_gtk,ID',
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer',
            'tindakan' => 'nullable|string',
        ]);

        $poin = PelanggaranPoinGtk::findOrFail($id);
        $poin->update([
            'IDpelanggaran_kategori' => $request->IDpelanggaran_kategori,
            'nama' => strtoupper($request->nama),
            'poin' => $request->poin,
            'tindakan' => $request->tindakan,
        ]);

        return back()->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroyPoin($id)
    {
        $poin = PelanggaranPoinGtk::findOrFail($id);
        $poin->delete();

        return back()->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }

    // ============================================================
    // DAFTAR INDISIPLINER GURU
    // ============================================================
    public function daftarIndex(Request $request)
    {
        $semesterList = Rombel::select('semester_id')->distinct()->get()->map(function ($item) {
            $tahun = substr($item->semester_id, 0, 4);
            $semester = substr($item->semester_id, 4, 1);
            return [
                'semester_id' => $item->semester_id,
                'tahun_pelajaran' => $tahun . '/' . ($tahun + 1),
                'semester' => $semester == '1' ? 'Ganjil' : 'Genap',
            ];
        });

        $semesterAktif = Rombel::orderByDesc('semester_id')->value('semester_id');
        $tahun = substr($semesterAktif, 0, 4);
        $semesterAngka = substr($semesterAktif, 4, 1);
        $tapelAktif = $tahun . '/' . ($tahun + 1);
        $semesterTeks = $semesterAngka == '1' ? '1' : '2';

        $kategoriList = PelanggaranKategoriGtk::with('pelanggaranPoinGtk')->orderBy('nama')->get();
        $gurus = Gtk::orderBy('nama')->get();

        $query = PelanggaranNilaiGtk::with(['detailPoinGtk.kategoriGtk', 'gtk'])
            ->latest('tanggal')
            ->latest('jam');

        // filter semester
        $semesterFilter = $request->filled('semester_id') ? $request->semester_id : $semesterAktif;
        $tahunReq = substr($semesterFilter, 0, 4);
        $semesterReq = substr($semesterFilter, 4, 1);
        $tapelReq = $tahunReq . '/' . ($tahunReq + 1);
        $query->where('tapel', $tapelReq)->where('semester', $semesterReq);

        // filter NIP opsional
        if ($request->filled('nip')) {
            $query->where('NIP', $request->nip);
        } else {
            $query->whereNotNull('NIP'); // pastikan hanya guru yang ada NIP
        }

        // filter pencarian nama guru
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('gtk', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%");
            });
        }

        $pelanggaranList = $query->paginate(10)->appends($request->query());

        return view('admin.indisipliner.guru.daftar.index', compact(
            'pelanggaranList',
            'semesterList',
            'kategoriList',
            'gurus',
            'semesterAktif'
        ));
    }

   // ============================================================
// SIMPAN DATA PELANGGARAN
// ============================================================
public function store(Request $request)
{
    $request->validate([
        'semester_id' => 'required|string',
        'tanggal' => 'required|date',
        'jam' => 'required',
        'nip' => 'nullable|exists:gtks,nip',
        'IDpelanggaran_poin' => 'required|exists:pelanggaran_poin_gtk,ID',
    ]);

    $poin = PelanggaranPoinGtk::findOrFail($request->IDpelanggaran_poin);
    $tahun = substr($request->semester_id, 0, 4);
    $semester = substr($request->semester_id, 4, 1);
    $tapel = $tahun . '/' . ($tahun + 1);

    // pastikan NIP selalu ada, isi '-' jika kosong
    $nip = $request->nip ?: '-';

    PelanggaranNilaiGtk::create([
        'NIP' => $nip,
        'IDpelanggaran_poin' => $request->IDpelanggaran_poin,
        'tanggal' => $request->tanggal,
        'jam' => $request->jam,
        'poin' => $poin->poin,
        'tapel' => $tapel,
        'semester' => $semester,
    ]);

    return redirect()->route('admin.indisipliner.guru.daftar.index')
        ->with('success', 'Data pelanggaran guru berhasil disimpan.');
}


    // ============================================================
    // HAPUS DATA
    // ============================================================
    public function destroy(PelanggaranNilaiGtk $pelanggaran)
    {
        $pelanggaran->delete();
        return back()->with('success', 'Data pelanggaran guru berhasil dihapus.');
    }

    // ============================================================
    // REKAPITULASI
    // ============================================================
    public function rekapitulasiIndex(Request $request)
    {
        $guruList = Gtk::orderBy('nama')->get();
        $guru = null;
        $pelanggaranGuru = null;
        $totalPoin = 0;
        $sanksiAktif = null;

        if ($request->filled('nip')) {
            $guru = Gtk::where('nip', $request->nip)->first();

            if ($guru) {
                $pelanggaranGuru = PelanggaranNilaiGtk::where('NIP', $guru->nip)
                    ->with('detailPoinGtk')
                    ->orderBy('tanggal', 'desc')
                    ->get();

                $totalPoin = $pelanggaranGuru->sum('poin');

                $sanksiAktif = PelanggaranSanksiGtk::where('poin_min', '<=', $totalPoin)
                    ->where('poin_max', '>=', $totalPoin)
                    ->first();
            } else {
                return back()->withErrors(['nip' => 'Guru dengan NIP tersebut tidak ditemukan.'])
                    ->withInput();
            }
        }

        return view('admin.indisipliner.guru.rekapitulasi.index', compact(
            'guruList',
            'guru',
            'pelanggaranGuru',
            'totalPoin',
            'sanksiAktif'
        ));
    }
}
