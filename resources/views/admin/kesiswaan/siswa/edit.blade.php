@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan / Data Siswa /</span> Edit Data</h4>

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

