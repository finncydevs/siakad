<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Models\AbsensiSiswa;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\IzinSiswa;
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
    DB::beginTransaction();
    try {
        $token = $request->input('token');
        $waktuScan = Carbon::now();
        $tanggalScan = $waktuScan->toDateString();

        // ALUR 1: PROSES SCAN KEMBALI (TIKET MASUK)
        $izinKembali = IzinSiswa::where('token_sementara', $token)->where('status', 'SEDANG_KELUAR')->first();
        if ($izinKembali) {
            if ($waktuScan->gt(Carbon::parse($izinKembali->jam_izin_selesai))) {
                return response()->json(['success' => false, 'message' => 'Waktu izin Anda untuk kembali sudah berakhir.'], 400);
            }
            $izinKembali->waktu_kembali = $waktuScan;
            $izinKembali->status = 'DIGUNAKAN';
            $izinKembali->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Selamat datang kembali, ' . $izinKembali->siswa->nama . '!']);
        }

        // ALUR 2: PROSES SCAN PRIBADI (IDENTIFIKASI SISWA)
        $siswa = Siswa::where('qr_token', $token)->first();
        if (!$siswa) { return response()->json(['success' => false, 'message' => 'QR Code tidak valid!'], 404); }

        $absensiHariIni = AbsensiSiswa::where('siswa_id', $siswa->id)->where('tanggal', $tanggalScan)->lockForUpdate()->first();
        $izinHariIni = IzinSiswa::where('siswa_id', $siswa->id)->where('tanggal_izin', $tanggalScan)->whereIn('status', ['DISETUJUI', 'SEDANG_KELUAR'])->first();

        // SUB-ALUR A: JIKA SISWA MEMILIKI IZIN AKTIF
        if ($izinHariIni) {
            if ($izinHariIni->tipe_izin == 'KELUAR_SEMENTARA' && $izinHariIni->status == 'DISETUJUI') {
                if (!$absensiHariIni || !$absensiHariIni->jam_masuk) { return response()->json(['success' => false, 'message' => 'Anda harus absen masuk terlebih dahulu sebelum keluar.'], 400); }
                $izinHariIni->waktu_keluar = $waktuScan;
                $izinHariIni->status = 'SEDANG_KELUAR';
                $izinHariIni->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Izin keluar dikonfirmasi. Gunakan QR sementara saat kembali.']);
            }
            if ($izinHariIni->tipe_izin == 'PULANG_AWAL' && $izinHariIni->status == 'DISETUJUI') {
                if (!$absensiHariIni || !$absensiHariIni->jam_masuk) { return response()->json(['success' => false, 'message' => 'Anda harus absen masuk terlebih dahulu.'], 400); }
                if ($waktuScan->lt(Carbon::parse($izinHariIni->jam_izin_mulai))) { return response()->json(['success' => false, 'message' => 'Belum waktunya untuk pulang sesuai izin.'], 400); }
                
                $absensiHariIni->jam_pulang = $waktuScan->toTimeString();
                $absensiHariIni->status_kehadiran = 'Pulang Awal (Izin)';
                $absensiHariIni->keterangan = $izinHariIni->alasan;
                $absensiHariIni->save();
                $izinHariIni->status = 'DIGUNAKAN';
                $izinHariIni->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Sampai Jumpa, '. $siswa->nama, 'status' => 'Pulang Awal (Izin)', 'siswa' => $siswa]);
            }
            if ($izinHariIni->tipe_izin == 'DATANG_TERLAMBAT' && $izinHariIni->status == 'DISETUJUI') {
                if ($absensiHariIni && $absensiHariIni->jam_masuk) { return response()->json(['success' => false, 'message' => 'Anda sudah tercatat absen masuk hari ini.'], 409); }
                if ($waktuScan->gt(Carbon::parse($izinHariIni->jam_izin_selesai))) { return response()->json(['success' => false, 'message' => 'Batas waktu izin terlambat Anda sudah berakhir.'], 400); }
                AbsensiSiswa::updateOrCreate(
                    ['siswa_id' => $siswa->id, 'tanggal' => $tanggalScan],
                    ['status' => 'Hadir', 'jam_masuk' => $waktuScan->toTimeString(), 'status_kehadiran' => 'Hadir (Dispensasi)', 'keterangan' => $izinHariIni->alasan, 'dicatat_oleh' => auth()->id() ?? 1]
                );
                $izinHariIni->status = 'DIGUNAKAN';
                $izinHariIni->save();
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Selamat Datang, '. $siswa->nama, 'status' => 'Hadir (Dispensasi)', 'siswa' => $siswa]);
            }
        }

        // SUB-ALUR B: JIKA TIDAK ADA IZIN, JALANKAN LOGIKA NORMAL
        $namaHariIni = $waktuScan->isoFormat('dddd');
        $pengaturan = DB::table('pengaturan_absensi')->where('hari', $namaHariIni)->first();
        
        // --- PERBAIKAN DI SINI ---
        if (!$pengaturan) { 
            // Mengganti "throw new Exception" dengan respons JSON yang terkontrol
            return response()->json(['success' => false, 'message' => "Pengaturan absensi untuk hari {$namaHariIni} tidak ditemukan. Silakan hubungi admin."], 400);
        }
        // --- AKHIR PERBAIKAN ---

        if (!$pengaturan->is_active) { return response()->json(['success' => false, 'message' => "Hari {$namaHariIni} tidak ada jadwal absensi."], 400); }
        $isLibur = DB::table('hari_libur')->where('tanggal', $tanggalScan)->exists();
        if ($isLibur) { return response()->json(['success' => false, 'message' => 'Hari ini adalah hari libur.'], 400); }
        if ($absensiHariIni && in_array($absensiHariIni->status, ['Sakit', 'Izin', 'Alfa'])) {
            return response()->json(['success' => false, 'message' => "Scan ditolak. Status Anda sudah tercatat '{$absensiHariIni->status}'.", 'siswa' => $siswa->only(['nama', 'foto'])], 409);
        }

        if ($absensiHariIni && $absensiHariIni->jam_masuk) { // Proses Pulang Normal
            $jamPulangSekolah = Carbon::parse($pengaturan->jam_pulang_sekolah);
            if ($waktuScan->lt($jamPulangSekolah)) { return response()->json(['success' => false, 'message' => 'Belum waktunya untuk absen pulang.', 'siswa' => $siswa->only(['nama', 'foto'])], 400); }
            $absensiHariIni->jam_pulang = $waktuScan->toTimeString();
            $absensiHariIni->save();
            $responseData = ['success' => true, 'message' => "Sampai Jumpa, {$siswa->nama}!", 'status' => 'Pulang', 'siswa' => $siswa];
        
        } else { // Proses Masuk Normal
            $batasMasuk = Carbon::parse($pengaturan->jam_masuk_sekolah);
            $batasTerlambat = $batasMasuk->copy()->addMinutes($pengaturan->batas_toleransi_terlambat);
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
            $responseData = ['success' => true, 'message' => "Selamat Datang, {$siswa->nama}!", 'status' => $statusKehadiran, 'keterlambatan' => $keterlambatan, 'siswa' => $siswa];
        }

        DB::commit();
        return response()->json($responseData);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal memproses scan absensi: ' . $e->getMessage() . ' di baris ' . $e->getLine());
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server. Silakan coba lagi.'], 500);
    }
}

    /**
     * Mendapatkan data absensi hari ini untuk tampilan real-time.
     */
public function getTodaysScans()
{
    $today = Carbon::now()->toDateString();

    $absensiHariIni = AbsensiSiswa::where('tanggal', $today)
        ->whereNotNull('jam_masuk')
        ->with('siswa:id,nama,foto')
        // INI BAGIAN PENTINGNYA
        ->orderBy('jam_masuk', 'desc') // <-- Pastikan diurutkan berdasarkan 'jam_masuk' secara descending
        ->get();

    return response()->json($absensiHariIni);
}
}

