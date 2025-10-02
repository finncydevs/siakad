@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">PPDB /</span> Peserta Didik Baru
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Daftar Peserta Didik Baru</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Resi</th>
                            <th>Nama Peserta</th>
                            <th>Jenis Kelamin</th>
                            <th>Jurusan Diinginkan</th>
                            <th>Tempat, Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesertaDidik as $i => $peserta)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td><span class="fw-bold text-primary">{{ $peserta->nomor_resi }}</span></td>
                                <td>{{ $peserta->nama_lengkap }}</td>
                                <td>{{ $peserta->jenis_kelamin }}</td>
                                <td>{{ $peserta->jurusan }}</td>
                                <td>{{ $peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada peserta didik baru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
