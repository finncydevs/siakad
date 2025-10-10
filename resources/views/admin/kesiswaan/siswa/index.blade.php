@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan /</span> Data Siswa</h4>

{{-- Notifikasi --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Sukses!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- Card Container --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <form action="{{ route('admin.kesiswaan.siswa.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" id="search" class="form-control me-2" placeholder="Cari nama, NIS/NISN..." value="{{ request('search') }}">
                <select name="rombel_id" id="rombel_id" class="form-select me-2" style="width: 200px;">
                    <option value="">Semua Kelas</option>
                    @foreach($rombels as $rombel)
                    <option value="{{ $rombel->id }}" {{ request('rombel_id') == $rombel->id ? 'selected' : '' }}>
                        {{ $rombel->nama }}
                    </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary">Cari</button>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>NIS / NISN</th>
                        <th>L/P</th>
                        <th>Kelas Aktif</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $key => $siswa)
                    <tr>
                        {{-- Penomoran yang disesuaikan dengan paginasi --}}
                        <td>{{ ($siswas->currentPage() - 1) * $siswas->perPage() + $loop->iteration }}</td>
                        <td>
                            <img src="{{ $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://placehold.co/100x100/EFEFEF/AAAAAA?text=Foto' }}" alt="Avatar" style="width: 40px; height: 40px;" class="rounded-circle object-cover">
                        </td>
                        <td><strong>{{ $siswa->nama }}</strong></td>
                        <td>{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
                        <td>{{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $siswa->rombel?->nama_rombel ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                           <a href="{{ route('admin.kesiswaan.siswa.show', $siswa->id) }}" class="btn btn-info btn-sm" title="Lihat">
                                <i class="fa fa-eye"></i>
                           </a>
                           <a href="{{ route('admin.kesiswaan.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fa fa-edit"></i>
                           </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="mt-3 d-flex justify-content-end">
            {{-- appends() digunakan agar parameter search dan filter tetap ada saat pindah halaman --}}
            {{ $siswas->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
