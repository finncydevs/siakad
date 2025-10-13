@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan / Data Siswa /</span> Edit Data</h4>

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="alert-heading">Terdapat Kesalahan Input:</h5>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- 2. Menampilkan pesan sukses dari session (setelah redirect dari controller) --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.kesiswaan.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- PERBAIKAN DI SINI: Meneruskan data $siswa ke dalam include --}}
            @include('admin.kesiswaan.siswa._form-tabs', ['siswa' => $siswa])
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Data Siswa</button>
                 <a href="{{ route('admin.kesiswaan.siswa.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
