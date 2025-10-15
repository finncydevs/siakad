<?php

namespace App\Http\Controllers\Admin\JadwalPelajaran;

use App\Http\Controllers\Controller;
use App\Models\Rombel;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rombels = Rombel::orderBy('nama')->get();
        return view('admin.jadwal_pelajaran.index', compact('rombels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Rombel $rombel)
    {
        // --- LOGIKA BARU YANG LEBIH AMAN ---
        $pembelajaranData = json_decode($rombel->pembelajaran, true) ?? [];

        // Filter data untuk memastikan hanya item yang valid yang diproses
        // Ini akan mencegah error "Undefined array key" di view
        $availablePelajaran = collect($pembelajaranData)->filter(function ($p) {
            return is_array($p) && 
                   isset($p['mata_pelajaran_id']) && 
                   isset($p['nama_mata_pelajaran']) && 
                   isset($p['ptk_id_str']);
        })->values()->all();
        // --- AKHIR LOGIKA BARU ---

        $existingJadwal = JadwalPelajaran::where('rombel_id', $rombel->id)->get()
            ->keyBy(function($item) {
                return $item->hari . '_' . $item->jam_ke;
            });

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jamPelajaran = range(1, 10);

        return view('admin.jadwal_pelajaran.create', compact('rombel', 'availablePelajaran', 'existingJadwal', 'days', 'jamPelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Rombel $rombel)
    {
        JadwalPelajaran::where('rombel_id', $rombel->id)->delete();

        $waktuData = $request->input('waktu', []);

        if ($request->has('jadwal')) {
            foreach ($request->jadwal as $hari => $jamItems) {
                foreach ($jamItems as $jam_ke => $detail) {
                    if (!empty($detail['pembelajaran_id'])) {
                        [$pembelajaran_id, $nama_mata_pelajaran, $nama_guru] = explode('|', $detail['pembelajaran_id']);
                        
                        $waktu_mulai = $waktuData[$jam_ke]['mulai'] ?? '00:00';
                        $waktu_selesai = $waktuData[$jam_ke]['selesai'] ?? '00:00';

                        JadwalPelajaran::create([
                            'rombel_id' => $rombel->id,
                            'hari' => $hari,
                            'jam_ke' => $jam_ke,
                            'pembelajaran_id' => $pembelajaran_id,
                            'nama_mata_pelajaran' => $nama_mata_pelajaran,
                            'nama_guru' => $nama_guru,
                            'waktu_mulai' => $waktu_mulai,
                            'waktu_selesai' => $waktu_selesai,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.jadwal-pelajaran.create', $rombel->id)
            ->with('success', 'Jadwal pelajaran berhasil diperbarui!');
    }
}

