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
                        {{-- Contoh data statis (sementara) --}}
                        <tr>
                            <td>1</td>
                            <td><span class="fw-bold text-primary">RESI-001</span></td>
                            <td>Ahmad Fauzi</td>
                            <td>Laki-Laki</td>
                            <td>Rekayasa Perangkat Lunak</td>
                            <td>Bandung, 12 Agustus 2008</td>
                        </tr>
                        {{-- Nanti bisa diganti looping dari database --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
