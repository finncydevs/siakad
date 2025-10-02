<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AbsensiSiswaController extends Controller
{
    /**
     * Menampilkan halaman untuk memilih kelas (Absensi Harian).
     */
    public function index(Request $request)
{
    $tanggal = $request->input('tanggal', Carbon::now()->toDateString());

    $query = Rombel::whereNotNull('ptk_id')->with('waliKelas');
    
    // Ambil data dan filter untuk nama yang unik
    $uniqueRombels = $query->get()->unique('nama');

    // Lakukan pengurutan custom
    $rombels = $uniqueRombels->sortBy(function($rombel) {
        $nama = $rombel->nama;
        // Prioritas 1: Kelas XII
        if (str_starts_with($nama, 'XII')) {
            // BENAR: Menggunakan titik (.) untuk penggabungan string
            return '300' . substr($nama, 4); 
        }
        // Prioritas 2: Kelas XI
        if (str_starts_with($nama, 'XI')) {
            // BENAR: Menggunakan titik (.) untuk penggabungan string
            return '200' . substr($nama, 3);
        }
        // Prioritas 3: Kelas X
        if (str_starts_with($nama, 'X')) {
            // BENAR: Menggunakan titik (.) untuk penggabungan string
            return '100' . substr($nama, 2);
        }
        // Untuk kelas lain, letakkan di akhir
        return '400'; 
    });

    return view('admin.absensi.siswa.index', compact('rombels', 'tanggal'));
}

    /**
     * Menampilkan formulir absensi untuk kelas dan tanggal yang dipilih.
     */
   public function show(Request $request)
    {
        $request->validate([
            'rombel_id' => 'required|exists:rombels,id',
            'tanggal' => 'required|date',
        ]);

        $rombel = Rombel::findOrFail($request->rombel_id);
        $tanggal = $request->tanggal;

        // ... (logika mengambil data siswa tidak berubah)
        $anggotaRombelIds = json_decode($rombel->anggota_rombel, true);
        if (empty($anggotaRombelIds)) {
            return back()->with('error', 'Kelas ini tidak memiliki anggota siswa.');
        }
        $pesertaDidikIds = array_column($anggotaRombelIds, 'peserta_didik_id');
        $siswas = Siswa::whereIn('peserta_didik_id', $pesertaDidikIds)->orderBy('nama')->get();


        // Mengambil data absensi yang sudah ada (termasuk jam masuk & status kehadiran)
        $absensiRecords = AbsensiSiswa::where('tanggal', $tanggal)
            ->whereIn('siswa_id', $siswas->pluck('id'))
            ->get()
            ->keyBy('siswa_id');
        
        // Ambil pengaturan absensi untuk info jam masuk
        $pengaturan = DB::table('pengaturan_absensi')->first();
        
        $jadwal = null;
        $isGuru = false;
        $formAction = route('admin.absensi.siswa.store');

        return view('admin.absensi.siswa.show', compact(
            'rombel', 
            'siswas', 
            'tanggal', 
            'absensiRecords', 
            'jadwal', 
            'isGuru', 
            'formAction',
            'pengaturan' // <-- Kirim data pengaturan ke view
        ));
    }

    /**
     * Menyimpan data absensi dari form manual.
     */
    public function store(Request $request)
    {
        $request->validate([
            'absensi' => 'required|array',
            'tanggal' => 'required|date',
        ]);

        foreach ($request->absensi as $siswaId => $data) {
            // --- PERBAIKAN DI SINI ---
            // Cek apakah 'status' dikirimkan. Jika tidak, lewati siswa ini.
            if (!isset($data['status'])) {
                continue;
            }
            // --- AKHIR PERBAIKAN ---

            AbsensiSiswa::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $data['status'],
                    'keterangan' => $data['keterangan'] ?? null, // Ambil keterangan jika ada
                    'dicatat_oleh' => Auth::id() ?? 1,
                    'jadwal_id' => null,
                ]
            );
        }

        return back()->with('success', 'Data absensi berhasil disimpan.');
    }

    /**
     * Menampilkan halaman Kios Absensi QR Code.
     */
    public function showScanner()
    {
        return view('admin.absensi.siswa.scanner');
    }

    /**
     * Menangani logika saat QR Code dipindai.
     */

public function handleScan(Request $request)
{
    // Memulai transaksi database untuk memastikan integritas data
    DB::beginTransaction();

    try {
        $token = $request->input('token');
        $waktuScan = Carbon::now();
        $tanggalScan = $waktuScan->toDateString();

        // Mengambil pengaturan absensi berdasarkan HARI INI (Logika Dinamis)
        $namaHariIni = $waktuScan->isoFormat('dddd'); // e.g., "Senin", "Selasa"
        $pengaturan = DB::table('pengaturan_absensi')->where('hari', $namaHariIni)->first();

        // Validasi 1: Pastikan ada pengaturan untuk hari ini
        if (!$pengaturan) {
            throw new \Exception("Pengaturan absensi untuk hari {$namaHariIni} tidak ditemukan.");
        }

        // Validasi 2: Cek apakah hari ini jadwal absensi aktif
        if (!$pengaturan->is_active) {
            return response()->json(['success' => false, 'message' => "Hari {$namaHariIni} tidak ada jadwal absensi."], 400);
        }

        $siswa = Siswa::where('qr_token', $token)->first();
        if (!$siswa) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid!'], 404);
        }

        // Validasi 3: Cek hari libur nasional
        $isLibur = DB::table('hari_libur')->where('tanggal', $tanggalScan)->exists();
        if ($isLibur) { // Pengecekan isWeekend() tidak diperlukan lagi karena ada is_active
            return response()->json(['success' => false, 'message' => 'Hari ini adalah hari libur.'], 400);
        }

        // Mengunci record absensi untuk mencegah race condition
        $absensiHariIni = AbsensiSiswa::where('siswa_id', $siswa->id)
                                        ->where('tanggal', $tanggalScan)
                                        ->lockForUpdate()
                                        ->first();

        // Validasi 4: Mencegah override status Sakit, Izin, atau Alfa
        if ($absensiHariIni && in_array($absensiHariIni->status, ['Sakit', 'Izin', 'Alfa'])) {
            return response()->json([
                'success' => false,
                'message' => "Scan ditolak. Status Anda sudah tercatat '{$absensiHariIni->status}'.",
                'siswa'   => $siswa->only(['nama', 'foto'])
            ], 409); // 409 Conflict
        }

        // Skenario 1: Siswa melakukan absen PULANG
        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            $intervalMinimum = 5;
            if ($waktuScan->diffInMinutes(Carbon::parse($absensiHariIni->jam_masuk)) < $intervalMinimum) {
                return response()->json([
                    'success' => false, 'message' => 'Anda sudah tercatat presensi masuk hari ini.',
                    'siswa'   => $siswa->only(['nama', 'foto']),
                ], 409);
            }

            $jamPulangSekolah = Carbon::parse($pengaturan->jam_pulang_sekolah);
            $batasAkhirPulang = $jamPulangSekolah->copy()->addHours(3);

            if (!$waktuScan->between($jamPulangSekolah, $batasAkhirPulang)) {
                $pesan = $waktuScan->lt($jamPulangSekolah) ? 'Belum waktunya untuk absen pulang!' : 'Waktu untuk absen pulang sudah berakhir.';
                return response()->json(['success' => false, 'message' => $pesan, 'siswa' => $siswa->only(['nama', 'foto'])], 400);
            }

            $absensiHariIni->jam_pulang = $waktuScan->toTimeString();
            $absensiHariIni->save();
            $responseData = ['success' => true, 'message' => "Sampai Jumpa, {$siswa->nama}!", 'foto' => $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama).'&background=03c3ec&color=fff&size=120', 'status' => 'Pulang', 'siswa' => $siswa];
        
        } else { // Skenario 2: Siswa melakukan absen MASUK
            $batasMasuk = Carbon::parse($pengaturan->jam_masuk_sekolah);
            $batasTerlambat = $batasMasuk->copy()->addMinutes($pengaturan->batas_toleransi_terlambat);
            
            // Validasi 5: Jendela waktu absen masuk (mencegah absen terlalu pagi)
            $batasAwalMasuk = $batasMasuk->copy()->subMinutes(60); 
            if (!$waktuScan->between($batasAwalMasuk, $batasTerlambat)) {
                $pesan = $waktuScan->lt($batasAwalMasuk) ? 'Belum waktunya untuk absen masuk!' : 'Waktu untuk absen masuk sudah berakhir.';
                return response()->json(['success' => false, 'message' => $pesan, 'siswa' => $siswa->only(['nama', 'foto'])], 400);
            }
            
            $statusKehadiran = $waktuScan->gt($batasMasuk) ? 'Terlambat' : 'Tepat Waktu';
            $keterlambatan = ($statusKehadiran === 'Terlambat') ? $waktuScan->diffInMinutes($batasMasuk) : null;

            AbsensiSiswa::updateOrCreate(
                ['siswa_id' => $siswa->id, 'tanggal' => $tanggalScan],
                ['status' => 'Hadir', 'jam_masuk' => $waktuScan->toTimeString(), 'status_kehadiran' => $statusKehadiran, 'dicatat_oleh' => auth()->id() ?? 1]
            );

            $responseData = ['success' => true, 'message' => "Selamat Datang, {$siswa->nama}!", 'foto' => $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama).'&background=696cff&color=fff&size=120', 'status' => $statusKehadiran, 'keterlambatan' => $keterlambatan, 'siswa' => $siswa];
        }

        DB::commit();
        return response()->json($responseData);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal memproses scan absensi: ' . $e->getMessage(), ['token' => $request->input('token')]);
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'], 500);
    }
}


    public function getTodaysScans()
    {
        $today = Carbon::now()->toDateString();
        $absensiHariIni = AbsensiSiswa::where('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->with('siswa:id,nama,foto') // Ambil hanya data siswa yang relevan
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($absensiHariIni);
    }
}

