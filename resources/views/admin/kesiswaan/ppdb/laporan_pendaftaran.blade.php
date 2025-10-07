@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">PPDB /</span> Laporan Pendaftaran PPDB
</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Laporan Pendaftaran</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 70%">Kriteria</th>
                            <th style="width: 25%">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Data statis dulu, nanti bisa diganti dari controller --}}
                        <tr>
                            <td><strong>1</strong></td>
                            <td>Total Pendaftaran</td>
                            <td>120</td>
                        </tr>
                        <tr>
                            <td><strong>2</strong></td>
                            <td>Jumlah Pendaftar Laki-Laki</td>
                            <td>65</td>
                        </tr>
                        <tr>
                            <td><strong>3</strong></td>
                            <td>Jumlah Pendaftar Perempuan</td>
                            <td>55</td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>4</strong></td>
                            <td colspan="2"><strong>Laporan berdasarkan jalur pendaftaran</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Jalur Prestasi</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Jalur Reguler</td>
                            <td>80</td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>5</strong></td>
                            <td colspan="2"><strong>Laporan berdasarkan jurusan</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Rekayasa Perangkat Lunak</td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Akuntansi</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- TKJ</td>
                            <td>30</td>
                        </tr>
                        <tr class="table-active">
                            <td><strong>6</strong></td>
                            <td colspan="2"><strong>Laporan calon siswa registrasi (syarat lengkap) berdasarkan jurusan</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Rekayasa Perangkat Lunak</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- Akuntansi</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="ps-4">- TKJ</td>
                            <td>20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
