@extends('layouts.admin') {{-- Atau layouts.contentNavbarLayout, sesuaikan --}}

@section('title', 'Manajemen Voucher Siswa')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Keuangan /</span> Manajemen Voucher
    </h4>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <span class="alert-icon text-success me-2"><i class="ti ti-check ti-xs"></i></span>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center" role="alert">
           <span class="alert-icon text-danger me-2"><i class="ti ti-ban ti-xs"></i></span>
            <span>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </span>
        </div>
    @endif

    <div class="row">
        <!-- Form Tambah Voucher -->
        <div class="col-12 mb-4">
            <div class="card">
                <h5 class="card-header">Tambah Voucher Baru</h5>
                <div class="card-body">
                    <form action="{{ route('admin.keuangan.voucher.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label for="siswa_id" class="form-label">Untuk Siswa</label>
                                <select id="siswa_id" name="siswa_id" class="form-select" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($daftarSiswa as $siswa)
                                        <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>
                                            {{ $siswa->nama_siswa }} (NIS: {{ $siswa->nis }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nilai_voucher" class="form-label">Nilai Voucher (Rp)</label>
                                <input class="form-control" type="number" id="nilai_voucher" name="nilai_voucher" value="{{ old('nilai_voucher') }}" placeholder="50000" required />
                            </div>
                             <div class="mb-3 col-md-3">
                                <label for="tahun_pelajaran_id" class="form-label">Tahun Ajaran</label>
                                <select id="tahun_pelajaran_id" name="tahun_pelajaran_id" class="form-select" required>
                                    @foreach ($tahunAjarans as $ta)
                                        <option value="{{ $ta->id }}" @selected(old('tahun_pelajaran_id') == $ta->id)>
                                            {{ $ta->tahun_ajaran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="mb-3 col-md-2">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input class="form-control" type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Beasiswa" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2"><i class="ti ti-device-floppy me-1"></i> Simpan Voucher</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Ringkasan Keuangan Siswa -->
        <div class="col-12">
            <div class="card">
                 <h5 class="card-header">Ringkasan Keuangan Siswa</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Total Kewajiban</th>
                                <th>Total Bayar</th>
                                <th>Total Voucher</th>
                                <th>Sisa Tagihan</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($siswas as $siswa)
                                @php
                                    $totalKewajiban = $siswa->tagihans->sum('jumlah_tagihan') + $siswa->tunggakans->sum('total_tunggakan_awal');
                                    $totalBayar = $siswa->pembayarans->sum('jumlah_bayar');
                                    $totalVoucher = $siswa->vouchers->sum('nilai_voucher');
                                    $sisaTagihan = $totalKewajiban - $totalBayar - $totalVoucher;
                                @endphp
                                <tr>
                                    <td><strong>{{ $siswa->nama_siswa }}</strong></td>
                                    <td>Rp {{ number_format($totalKewajiban, 0, ',', '.') }}</td>
                                    <td class="text-success">Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
                                    <td class="text-info">Rp {{ number_format($totalVoucher, 0, ',', '.') }}</td>
                                    <td class="fw-bold {{ $sisaTagihan > 0 ? 'text-danger' : 'text-success' }}">
                                        Rp {{ number_format($sisaTagihan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

