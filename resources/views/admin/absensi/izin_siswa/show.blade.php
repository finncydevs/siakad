    @extends('layouts.admin')

    @section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manajemen Izin /</span> Detail Izin</h4>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5>Detail Izin untuk: <strong>{{ $izinSiswa->siswa->nama }}</strong></h5>
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 200px;">Tanggal Izin</td>
                            <td>: {{ \Carbon\Carbon::parse($izinSiswa->tanggal_izin)->isoFormat('dddd, D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td>Tipe Izin</td>
                            <td>: {{ $izinSiswa->tipe_izin }}</td>
                        </tr>
                        @if($izinSiswa->jam_izin_mulai)
                        <tr>
                            <td>Waktu Mulai</td>
                            <td>: {{ \Carbon\Carbon::parse($izinSiswa->jam_izin_mulai)->format('H:i') }} WIB</td>
                        </tr>
                        @endif
                        @if($izinSiswa->jam_izin_selesai)
                        <tr>
                            <td>Waktu Selesai</td>
                            <td>: {{ \Carbon\Carbon::parse($izinSiswa->jam_izin_selesai)->format('H:i') }} WIB</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Alasan</td>
                            <td>: {{ $izinSiswa->alasan }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: <span class="badge bg-label-info">{{ $izinSiswa->status }}</span></td>
                        </tr>
                        <tr>
                            <td>Dicatat Oleh</td>
                            <td>: {{ $izinSiswa->pencatat->name }}</td>
                        </tr>
                    </table>
                </div>

                @if($izinSiswa->tipe_izin == 'KELUAR_SEMENTARA' && $izinSiswa->status == 'DISETUJUI')
                <div class="col-md-4 text-center">
                    <h5>QR Code Tiket Kembali</h5>
                    <div class="my-3">
                        {!! QrCode::size(250)->generate($izinSiswa->token_sementara) !!}
                    </div>
                    <p class="text-muted">Minta siswa untuk memindai QR Code ini saat akan masuk kembali ke area sekolah.</p>
                </div>
                @endif
            </div>

            <a href="{{ route('admin.absensi.izin-siswa.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Izin</a>
        </div>
    </div>
    @endsection
    
