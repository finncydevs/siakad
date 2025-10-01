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
    // Memulai transaction untuk menjaga data tetap konsisten.
    // Jika ada error, semua operasi database akan dibatalkan.
    DB::beginTransaction();

    try {
        // --- 1. Validasi Input & Kondisi Awal ---
        $token = $request->input('token');
        $waktuScan = Carbon::now();
        $tanggalScan = $waktuScan->toDateString();

        $siswa = Siswa::where('qr_token', $token)->first();
        if (!$siswa) {
            // Menggunakan status 404 Not Found untuk QR yang tidak terdaftar
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid!'], 404);
        }

        $pengaturan = DB::table('pengaturan_absensi')->first();
        if (!$pengaturan) {
            // Melempar exception jika pengaturan krusial tidak ada, akan ditangkap oleh blok catch.
            throw new \Exception('Pengaturan absensi belum dikonfigurasi di database.');
        }

        $isLibur = DB::table('hari_libur')->where('tanggal', $tanggalScan)->exists();
        if ($isLibur || $waktuScan->isWeekend()) {
            return response()->json(['success' => false, 'message' => 'Hari ini adalah hari libur.']);
        }

        // --- 2. Proses Logika Utama (Masuk atau Pulang) ---
        $absensiHariIni = AbsensiSiswa::where('siswa_id', $siswa->id)
                                      ->where('tanggal', $tanggalScan)
                                      ->first();

        // Jika sudah ada jam masuk, maka ini adalah absen PULANG
        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            $absensiHariIni->jam_pulang = $waktuScan->toTimeString();
            $absensiHariIni->save();

            $responseData = [
                'success' => true,
                'message' => "Sampai Jumpa, {$siswa->nama}!",
                'foto'    => $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama),
                'status'  => 'Pulang',
                'siswa'   => $siswa // Mengirim data siswa untuk ditampilkan di modal
            ];
        } else {
            // Jika belum ada jam masuk, ini adalah absen MASUK
            $batasMasuk = Carbon::parse($pengaturan->jam_masuk_sekolah);
            $batasTerlambat = $batasMasuk->copy()->addMinutes($pengaturan->batas_toleransi_terlambat);

            $statusKehadiran = $waktuScan->gt($batasTerlambat) ? 'Terlambat' : 'Tepat Waktu';
            $keterlambatan = null;
            if ($statusKehadiran === 'Terlambat') {
                $keterlambatan = $waktuScan->diffInMinutes($batasTerlambat);
            }

            AbsensiSiswa::updateOrCreate(
                ['siswa_id' => $siswa->id, 'tanggal' => $tanggalScan],
                [
                    'status'            => 'Hadir',
                    'jam_masuk'         => $waktuScan->toTimeString(),
                    'status_kehadiran'  => $statusKehadiran,
                    'dicatat_oleh'      => Auth::id() ?? 1,
                ]
            );

            $responseData = [
                'success'       => true,
                'message'       => "Selamat Datang, {$siswa->nama}!",
                'foto'          => $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama),
                'status'        => $statusKehadiran,
                'keterlambatan' => $keterlambatan,
                'siswa'         => $siswa
            ];
        }

        // --- 3. Finalisasi ---
        // Jika semua proses di atas berhasil tanpa error, simpan perubahan ke database.
        DB::commit();
        
        // Kirim respons sukses.
        return response()->json($responseData);

    } catch (\Exception $e) {
        // --- 4. Penanganan Error ---
        // Jika terjadi error di mana pun dalam blok 'try', batalkan semua operasi database.
        DB::rollBack();

        // Catat detail error ke dalam file log untuk dianalisis oleh developer.
        \Log::error('Gagal memproses scan absensi: ' . $e->getMessage());

        // Kirim respons error yang terstruktur ke frontend dengan status 500.
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.'
        ], 500);
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

