@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Penempatan Kelas</h4>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Penempatan Kelas Siswa</h5>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pilih_jalur" class="form-label">Pilih Jalur / Angkatan</label>
                        <select id="pilih_jalur" class="form-select">
                            <option value="">- Pilih -</option>
                            {{-- Looping jalur/angkatan dari controller --}}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="pilih_kelas" class="form-label">Pilih Kelas Tujuan</label>
                        <select id="pilih_kelas" class="form-select">
                            <option value="">- Pilih Kelas Tujuan -</option>
                            {{-- Looping kelas tujuan --}}
                        </select>
                    </div>
                </div>

                <div class="row">
                    {{-- Tabel siswa belum ditempatkan --}}
                    <div class="col-md-6">
                        <h6>Daftar Siswa Belum Ditempatkan</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                        <th>SEKOLAH ASAL</th>
                                        <th><input type="checkbox"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Maaf, data tidak ditemukan</td>
                                    </tr>
                                    {{-- Loop data siswa di sini --}}
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Tabel siswa sudah ditempatkan --}}
                    <div class="col-md-6">
                        <h6>Daftar Siswa Sudah Ditempatkan</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                        <th>KELAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Maaf, data tidak ditemukan</td>
                                    </tr>
                                    {{-- Loop data siswa di sini --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
