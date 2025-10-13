<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat/assets/') }}"
  data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kios Absensi QR</title>

    @vite(['resources/css/app.css'])

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto+Mono:wght@700&display=swap" rel="stylesheet">

    <style>
        /* CSS UNTUK PROMPT FULLSCREEN */
        #fullscreen-prompt {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(21, 22, 37, 0.85);
            display: flex; justify-content: center; align-items: center;
            z-index: 9999; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            flex-direction: column; color: white; text-align: center;
        }
        #enter-fullscreen-btn {
            font-size: 1.5rem; padding: 1rem 2rem;
            box-shadow: 0 8px 25px rgba(105, 108, 255, 0.5);
        }
        #fullscreen-prompt p {
            margin-top: 1.5rem; font-size: 1.1rem; max-width: 400px;
        }
        
        /* === LOGIKA VISIBILITAS KONTEN === */
        #main-content {
            display: none; opacity: 0; transition: opacity 0.3s ease-in-out;
        }
        body.fullscreen-active #main-content {
            display: block; opacity: 1;
        }
        body.fullscreen-active #fullscreen-prompt {
            display: none;
        }
        /* === END LOGIKA VISIBILITAS === */

        /* Sisa CSS Anda */
        :root {
            --kiosk-bg-light: #f5f5f9; --kiosk-border-color: #d9dee3;
            --kiosk-text-primary: #566a7f; --kiosk-text-secondary: #697a8d;
            --kiosk-primary: #696cff; --kiosk-success: #71dd37;
            --kiosk-warning: #ffab00; --kiosk-info: #03c3ec;
            --kiosk-danger: #ff3e1d;
        }
        body { background-color: var(--kiosk-bg-light); }
        .card.kiosk-card { font-family: 'Poppins', sans-serif; box-shadow: none; border: 1px solid var(--kiosk-border-color); }
        .clock-container { background-color: #ffffff; color: var(--kiosk-text-primary); padding: 1.5rem; border-radius: 0.5rem; text-align: center; margin-bottom: 2rem; border: 1px solid var(--kiosk-border-color); }
        .clock-time { font-family: 'Roboto Mono', monospace; font-size: 3.5rem; font-weight: 700; letter-spacing: 2px; color: var(--kiosk-primary); }
        .clock-date { font-size: 1.1rem; color: var(--kiosk-text-secondary); }
        .scanner-viewport { width: 100%; max-width: 400px; margin: 0 auto; position: relative; aspect-ratio: 1 / 1; border-radius: 0.5rem; overflow: hidden; border: 2px solid var(--kiosk-border-color); }
        #qr-reader { width: 100%; height: 100%; }
        #qr-reader video { width: 100% !important; height: 100% !important; object-fit: cover; transform: scaleX(-1);}
        #qr-reader > div:first-of-type { border: none !important; }
        .scanner-viewport::after { content: ''; position: absolute; left: 0; top: 0; width: 100%; height: 4px; background: linear-gradient(90deg, transparent, var(--kiosk-primary), transparent); box-shadow: 0 0 10px var(--kiosk-primary); animation: scanline 3s linear infinite; z-index: 10; }
        @keyframes scanline { 0% { top: 0; } 100% { top: 100%; } }
        .recent-scans-list { list-style: none; padding: 0; margin: 0; max-height: 500px; overflow-y: auto; }
        .recent-scans-list li { display: flex; align-items: center; padding: 0.8rem 0.5rem; border-bottom: 1px solid var(--kiosk-border-color); opacity: 0; transform: translateX(20px); animation: slideIn 0.4s forwards ease-out; }
        .recent-scans-list li:last-child { border-bottom: none; }
        #recent-scans-list li img.scan-photo { width: 45px !important; height: 45px !important; border-radius: 50%; object-fit: cover; margin-right: 1rem; flex-shrink: 0; }
        .scan-details { flex-grow: 1; }
        .scan-name { font-weight: 600; color: var(--kiosk-text-primary); }
        .scan-time { font-size: 0.85rem; color: var(--kiosk-text-secondary); }
        .status-badge { font-size: 0.8rem; }
        @keyframes slideIn { to { opacity: 1; transform: translateX(0); } }
        #scanResultModal .modal-content { border: none; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15); }
        #modal-status-icon { width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 1.5rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white; }
        .student-photo-modal { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: border-color 0.3s ease; }
        #modal-student-name { color: var(--kiosk-text-primary); }
        #modal-status-info { color: var(--kiosk-text-secondary); font-size: 1.1rem; }
        .status-success #modal-status-icon { background-color: var(--kiosk-success); } .status-success .student-photo-modal { border: 4px solid var(--kiosk-success); }
        .status-warning #modal-status-icon { background-color: var(--kiosk-warning); } .status-warning .student-photo-modal { border: 4px solid var(--kiosk-warning); }
        .status-info #modal-status-icon { background-color: var(--kiosk-info); } .status-info .student-photo-modal { border: 4px solid var(--kiosk-info); }
        .status-danger #modal-status-icon { background-color: var(--kiosk-danger); } .status-danger .student-photo-modal { border: 4px solid var(--kiosk-danger); }
    </style>
</head>

<body>
    <div id="fullscreen-prompt">
        <button id="enter-fullscreen-btn" class="btn btn-primary btn-lg">
            <i class='bx bx-fullscreen me-2'></i>Masuk Mode Kios
        </button>
        <p>Aplikasi ini dirancang untuk berjalan dalam mode layar penuh. Tekan tombol 'ESC' untuk keluar.</p>
    </div>

    @include('layouts.partials.toast')

    <div class="container-fluid p-4" id="main-content">
        <div class="row">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="card kiosk-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kios Absensi QR</h5>
                        <div class="text-secondary fw-light">Tekan 'ESC' untuk keluar</div>
                    </div>
                    <div class="card-body">
                        <div class="clock-container">
                            <div id="clock-time" class="clock-time">00:00:00</div>
                            <div id="clock-date" class="clock-date">Memuat...</div>
                        </div>

                        {{-- ====================================================== --}}
                        {{-- |    KODE JADWAL HARI INI YANG SUDAH DIPERBAIKI      | --}}
                        {{-- ====================================================== --}}

                        {{-- Cek dulu apakah jadwal untuk hari ini ada DAN aktif --}}
                        @if ($jadwalHariIni && $jadwalHariIni->is_active)
                            <div class="text-center p-3 mb-4" style="background-color: #f7f7f9; border-radius: 0.5rem; border: 1px solid #e1e3e8;">
                                <h5 class="mb-3">
                                    Jadwal Hari Ini ({{ $jadwalHariIni->hari }})
                                </h5>
                                <div class="d-flex justify-content-around align-items-center">
                                    
                                    {{-- Info Jam Masuk --}}
                                    <div class="px-2">
                                        <i class='bx bx-log-in-circle bx-md text-primary'></i>
                                        <div class="small text-muted mt-1">Masuk</div>
                                        <div class="fs-4 fw-bold" style="color: #566a7f;">
                                            {{ date('H:i', strtotime($jadwalHariIni->jam_masuk_sekolah)) }}
                                        </div>
                                    </div>

                                    {{-- Info Jam Pulang --}}
                                    <div class="px-2">
                                        <i class='bx bx-log-out-circle bx-md text-info'></i>
                                        <div class="small text-muted mt-1">Pulang</div>
                                        <div class="fs-4 fw-bold" style="color: #566a7f;">
                                            {{ date('H:i', strtotime($jadwalHariIni->jam_pulang_sekolah)) }}
                                        </div>
                                    </div>

                                    {{-- Info Toleransi --}}
                                    <div class="px-2">
                                        <i class='bx bx-time bx-md text-warning'></i>
                                        <div class="small text-muted mt-1">Toleransi</div>
                                        <div class="fs-4 fw-bold" style="color: #566a7f;">
                                            {{ $jadwalHariIni->batas_toleransi_terlambat }} <span class="fs-6 fw-normal">menit</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            {{-- Tampilan jika hari ini libur atau tidak ada jadwal --}}
                            <div class="alert alert-success text-center" role="alert">
                                <i class='bx bx-calendar-star me-2'></i>
                                <strong>Hari ini tidak ada jadwal absensi. Selamat beristirahat!</strong>
                            </div>
                        @endif

                        {{-- ====================================================== --}}
                        {{-- |                AKHIR DARI KODE BARU                  | --}}
                        {{-- ====================================================== --}}

                        <div class="scanner-viewport">
                            <div id="qr-reader"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card kiosk-card">
                    <div class="card-header">
                        <h5 class="mb-0">Aktivitas Hari Ini</h5>
                    </div>
                    <div class="card-body">
                         <ul id="recent-scans-list" class="recent-scans-list">
                            <li class="text-center border-0" style="animation: none;">Memuat data...</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="scanResultModal" tabindex="-1" aria-labelledby="scanResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body p-4">
                    <div id="modal-status-icon"></div>
                    <img id="modal-student-photo" src="" alt="Foto Siswa" class="student-photo-modal mb-3">
                    <h4 id="modal-student-name" class="card-title fs-3 mt-2">Memproses...</h4>
                    <p id="modal-status-info" class="card-text fs-5 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                const toast = new bootstrap.Toast(document.getElementById('successToast'));
                document.getElementById('successToastBody').innerHTML = "{{ session('success') }}";
                toast.show();
            @endif
            @if(session('error'))
                const toast = new bootstrap.Toast(document.getElementById('errorToast'));
                document.getElementById('errorToastBody').innerHTML = "{{ session('error') }}";
                toast.show();
            @endif
            @if(session('info'))
                const toast = new bootstrap.Toast(document.getElementById('infoToast'));
                document.getElementById('infoToastBody').innerHTML = "{{ session('info') }}";
                toast.show();
            @endif
        });
    </script>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tone/14.7.77/Tone.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- LOGIKA BARU UNTUK MEMAKSA FULLSCREEN ---
        const enterFullscreenBtn = document.getElementById('enter-fullscreen-btn');
        function handleFullscreenChange() {
            if (document.fullscreenElement) {
                document.body.classList.add('fullscreen-active');
            } else {
                document.body.classList.remove('fullscreen-active');
            }
        }
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        enterFullscreenBtn.addEventListener('click', () => {
            document.documentElement.requestFullscreen().catch(err => {
                alert(`Gagal masuk mode layar penuh. Error: ${err.message}`);
            });
            initAudio(); 
        });

        // --- Sisa skrip Anda (tidak ada perubahan dari sini ke bawah) ---
        const modalEl = document.getElementById('scanResultModal');
        const scanResultModal = new bootstrap.Modal(modalEl);
        const modalContent = modalEl.querySelector('.modal-content');
        const modalIcon = document.getElementById('modal-status-icon');
        const modalPhoto = document.getElementById('modal-student-photo');
        const modalName = document.getElementById('modal-student-name');
        const modalStatus = document.getElementById('modal-status-info');
        const recentScansList = document.getElementById('recent-scans-list');
        let isScanning = false;
        let successSynth, errorSynth, infoSynth;
        let isAudioReady = false;
        async function initAudio() {
            if (isAudioReady) return;
            try {
                await Tone.start();
                successSynth = new Tone.Synth({ oscillator: { type: 'sine' }, envelope: { attack: 0.005, decay: 0.1, sustain: 0.3, release: 0.1 } }).toDestination();
                errorSynth = new Tone.Synth({ oscillator: { type: 'square' }, envelope: { attack: 0.005, decay: 0.2, sustain: 0.1, release: 0.2 } }).toDestination();
                infoSynth = new Tone.Synth({ oscillator: { type: 'triangle' }, envelope: { attack: 0.01, decay: 0.1, sustain: 0.2, release: 0.1 } }).toDestination();
                isAudioReady = true;
                console.log('AudioContext siap!');
            } catch (e) {
                console.error("Gagal memulai AudioContext:", e);
            }
        }
        const timeEl = document.getElementById('clock-time');
        const dateEl = document.getElementById('clock-date');
        function updateClock() {
            const now = new Date();
            timeEl.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(/\./g, ':');
            dateEl.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        }
        setInterval(updateClock, 1000);
        updateClock();
        function addScanToList(scanData) {
            if (recentScansList.querySelector('.text-center')) {
                recentScansList.innerHTML = '';
            }
            const li = document.createElement('li');
            let displayTime = '';
            if (scanData.jam_pulang) {
                displayTime = new Date(`1970-01-01T${scanData.jam_pulang}`).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            } else if (scanData.jam_masuk) {
                displayTime = new Date(`1970-01-01T${scanData.jam_masuk}`).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            } else {
                displayTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
            let statusBadge = '';
            const statusKehadiran = scanData.status_kehadiran;
            if (statusKehadiran === 'Tepat Waktu') {
                statusBadge = `<span class="badge rounded-pill bg-label-success status-badge">Masuk</span>`;
            } else if (statusKehadiran === 'Terlambat') {
                statusBadge = `<span class="badge rounded-pill bg-label-warning status-badge">Terlambat</span>`;
            } else if (scanData.jam_pulang && statusKehadiran !== 'Pulang Awal (Izin)') {
                statusBadge = `<span class="badge rounded-pill bg-label-info status-badge">Pulang</span>`;
            } else if (statusKehadiran === 'Hadir (Dispensasi)') {
                statusBadge = `<span class="badge rounded-pill bg-label-primary status-badge">Dispensasi</span>`;
            } else if (statusKehadiran === 'Pulang Awal (Izin)') {
                statusBadge = `<span class="badge rounded-pill bg-label-info status-badge">Pulang Awal</span>`;
            }
            const photoUrl = scanData.siswa.foto ? `{{ asset('storage') }}/${scanData.siswa.foto}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(scanData.siswa.nama)}&background=696cff&color=fff&size=45`;
            li.innerHTML = `
                <img src="${photoUrl}" class="scan-photo" alt="Foto ${scanData.siswa.nama}">
                <div class="scan-details">
                    <div class="scan-name">${scanData.siswa.nama}</div>
                    <div class="scan-time">Jam: ${displayTime}</div>
                </div>
                ${statusBadge}
            `;
            recentScansList.append(li);
            if (recentScansList.children.length > 50) {
                recentScansList.lastChild.remove();
            }
        }
        function fetchInitialScans() {
            fetch("{{ route('admin.absensi.siswa.get_todays_scans') }}")
                .then(response => response.json())
                .then(data => {
                    recentScansList.innerHTML = '';
                    if (data.length === 0) {
                        recentScansList.innerHTML = '<li class="text-center text-muted border-0" style="animation: none;">Belum ada aktivitas.</li>';
                        return;
                    }
                    data.forEach(scan => addScanToList(scan));
                })
                .catch(error => {
                    console.error("Gagal mengambil data absensi awal:", error);
                    recentScansList.innerHTML = '<li class="text-center text-danger border-0" style="animation: none;">Gagal memuat data.</li>';
                });
        }
        function showFeedback(type, message, studentName, statusInfo, photoUrl) {
            modalContent.className = `modal-content text-center status-${type}`;
            let iconClass = '';
            if (type === 'loading') { iconClass = 'bx bx-loader-alt bx-spin'; }
            else if (type === 'success') { iconClass = 'bx bx-check'; }
            else if (type === 'warning') { iconClass = 'bx bx-error-circle'; }
            else if (type === 'info') { iconClass = 'bx bx-info-circle'; }
            else { iconClass = 'bx bx-x'; }
            modalIcon.innerHTML = `<i class='${iconClass}'></i>`;
            modalPhoto.src = photoUrl || `https://ui-avatars.com/api/?name=?&background=dee3e0&color=fff&size=120`;
            modalName.textContent = studentName;
            modalStatus.textContent = statusInfo;
            if (isAudioReady && type !== 'loading') {
                if (type === 'danger' || type === 'warning') { errorSynth.triggerAttackRelease("C3", "0.2"); }
                else if (type === 'info') { infoSynth.triggerAttackRelease("A4", "0.1"); }
                else { successSynth.triggerAttackRelease("C5", "0.1"); }
            }
            scanResultModal.show();
            if (type !== 'loading') { setTimeout(() => scanResultModal.hide(), 4000); }
        }
        function onScanSuccess(decodedText, decodedResult) {
            if (isScanning) return;
            isScanning = true;
            const loadingSpinnerUrl = `https://ui-avatars.com/api/?name=.&background=dee3e0&color=fff&size=120&font-size=0.1`;
            showFeedback('loading', '', 'Memproses...', 'Mohon tunggu sebentar...', loadingSpinnerUrl);
            fetch("{{ route('admin.absensi.siswa.handle_scan') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ token: decodedText })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        let err = new Error(errorData.message || 'Error tidak diketahui');
                        err.data = errorData;
                        throw err;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    let statusType = 'success', mainMessage, subMessage;
                    const status = data.status, studentName = data.siswa?.nama;
                    const fotoUrl = data.siswa?.foto ? `{{ asset('storage') }}/${data.siswa.foto}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(studentName)}&background=696cff&color=fff&size=120`;
                    if (status === 'Terlambat') {
                        statusType = 'warning'; mainMessage = studentName; subMessage = `Status: Terlambat ${data.keterlambatan} menit.`;
                    } else if (status === 'Tepat Waktu' || status === 'Hadir (Dispensasi)') {
                        statusType = 'success'; mainMessage = studentName; subMessage = 'Status: Kehadiran Tercatat.';
                    } else if (status === 'Pulang' || status === 'Pulang Awal' || status === 'Pulang Awal (Izin)') {
                        statusType = 'info'; mainMessage = studentName; subMessage = 'Status: Absen Pulang Tercatat.';
                    } else {
                        statusType = 'info'; mainMessage = data.message; subMessage = studentName || 'Status: Aksi Berhasil Dicatat.';
                    }
                    showFeedback(statusType, data.message, mainMessage, subMessage, fotoUrl);
                    fetchInitialScans();
                } else {
                    const photoPlaceholder = `https://ui-avatars.com/api/?name=X&background=ff3e1d&color=fff&size=120`;
                    showFeedback('danger', 'Gagal', data.message, 'Silakan coba lagi.', photoPlaceholder);
                }
            })
            .catch(error => {
                console.error('Scan Error:', error);
                if (error.data && error.data.siswa) {
                    const studentName = error.data.siswa.nama;
                    const photoUrl = error.data.siswa.foto ? `{{ asset('storage') }}/${error.data.siswa.foto}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(studentName)}&background=ffab00&color=fff&size=120`;
                    showFeedback('warning', 'Peringatan', studentName, error.message, photoUrl);
                } else {
                    const photoPlaceholder = `https://ui-avatars.com/api/?name=X&background=ff3e1d&color=fff&size=120`;
                    showFeedback('danger', 'Error Kritis', error.message || 'Tidak dapat memproses permintaan.', 'Periksa koneksi atau hubungi admin.', photoPlaceholder);
                }
            })
            .finally(() => { setTimeout(() => { isScanning = false; }, 3000); });
        }
        const readerEl = document.getElementById('qr-reader');
        function startScanner(config) {
            const html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", config, false);
            html5QrcodeScanner.render(onScanSuccess, (error) => {});
        }
        const baseConfig = { fps: 10, qrbox: { width: 250, height: 250 }, supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA], rememberLastUsedCamera: true };
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) { startScanner(baseConfig); }
                else { throw new Error("Tidak ada kamera yang ditemukan di perangkat ini."); }
            }).catch(err => {
                console.error("Gagal mendapatkan daftar kamera:", err);
                readerEl.innerHTML = `<div class="alert alert-danger d-flex align-items-center" role="alert"><i class='bx bx-error-circle me-2' style="font-size: 1.5rem;"></i><div><strong>Akses Kamera Gagal.</strong><br>Pastikan Anda telah memberikan izin dan tidak ada aplikasi lain yang sedang menggunakan kamera.</div></div>`;
            });
        } else {
            console.error("getUserMedia tidak didukung oleh browser ini.");
            readerEl.innerHTML = `<div class="alert alert-danger">Browser Anda tidak mendukung akses kamera.</div>`;
        }
        fetchInitialScans();
    });
    </script>

    @vite(['resources/js/app.js'])
</body>
</html>