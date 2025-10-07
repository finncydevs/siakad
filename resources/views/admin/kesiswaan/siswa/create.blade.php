@extends('layouts.admin')

@section('title', 'Tambah Data Siswa')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Kesiswaan / Data Siswa /</span> Tambah Baru
</h4>

{{-- Notifikasi Error Validasi --}}
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

<form action="{{ route('admin.kesiswaan.siswa.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card">
        <div class="card-header">
            <div class="nav-align-top">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tab-pribadi">
                            <i class="ti ti-user-circle me-1"></i> Pribadi
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-tempat-tinggal">
                            <i class="ti ti-map-pin me-1"></i> Tempat Tinggal
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-ortu">
                             <i class="ti ti-users me-1"></i> Ortu/Wali
                        </button>
                    </li>
                     <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tab-akademik">
                             <i class="ti ti-school me-1"></i> Akademik
                        </button>
                    </li>
                    {{-- Tambahkan tab lain jika diperlukan --}}
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content p-0">
                <div class="tab-pane fade show active" id="tab-pribadi" role="tabpanel">
                    <p>Konten untuk form <strong>Data Pribadi</strong> akan ditempatkan di sini. Anda bisa membuat file partial terpisah untuk menjaga kerapian kode.</p>
                </div>
                <div class="tab-pane fade" id="tab-tempat-tinggal" role="tabpanel">
                     <p>Konten untuk form <strong>Tempat Tinggal</strong> akan ditempatkan di sini.</p>
                </div>
                 <div class="tab-pane fade" id="tab-ortu" role="tabpanel">
                    {{-- @include('admin.kesiswaan.siswa.partials._form-ortu') --}}
                     <p>Konten untuk form <strong>Orang Tua/Wali</strong> akan ditempatkan di sini.</p>
                </div>
                <div class="tab-pane fade" id="tab-akademik" role="tabpanel">
                    {{-- @include('admin.kesiswaan.siswa.partials._form-akademik') --}}
                     <p>Konten untuk form <strong>Akademik</strong> (seperti NIS, NISN, rombel) akan ditempatkan di sini.</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
             <button type="submit" class="btn btn-primary">
                <i class="ti ti-device-floppy me-1"></i> Simpan Data
            </button>
            <a href="{{ route('admin.kesiswaan.siswa.index') }}" class="btn btn-label-secondary">Batal</a>
        </div>
    </div>
</form>
@endsection
