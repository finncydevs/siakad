@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan /</span> Data Siswa</h4>

{{-- Notifikasi --}}
@if (session('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <span class="alert-icon text-success me-2"><i class="ti ti-check ti-xs"></i></span>
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center row py-2 gap-3 gap-md-0">
            <div class="col-md-4">
                 <a href="{{ route('admin.kesiswaan.siswa.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Tambah Siswa
                </a>
            </div>
            <div class="col-md-8">
                <form action="{{ route('admin.kesiswaan.siswa.index') }}" method="GET" class="d-flex justify-content-end align-items-center">
                    <label for="rombel_id" class="me-2">Kelas:</label>
                    <select name="rombel_id" id="rombel_id" class="form-select" onchange="this.form.submit()" style="width: 250px;">
                        <option value="">Semua Kelas</option>
                        @foreach($rombels as $rombel)
                        <option value="{{ $rombel->id }}" {{ request('rombel_id') == $rombel->id ? 'selected' : '' }}>
                            {{ $rombel->nama_rombel }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
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
            <tbody class="table-border-bottom-0">
                @forelse($siswas as $key => $siswa)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-sm pull-up" title="{{ $siswa->nama }}">
                                <img src="{{ $siswa->foto_url }}" alt="Avatar" class="rounded-circle">
                            </li>
                        </ul>
                    </td>
                    <td><strong>{{ $siswa->nama }}</strong></td>
                    <td>{{ $siswa->nis ?? '-' }} / {{ $siswa->nisn ?? '-' }}</td>
                    <td>{{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td>
                        <span class="badge bg-label-primary me-1">{{ $siswa->rombel?->nama_rombel ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.kesiswaan.siswa.show', $siswa->id) }}"><i class="ti ti-eye me-1"></i> Lihat</a>
                                <a class="dropdown-item" href="{{ route('admin.kesiswaan.siswa.edit', $siswa->id) }}"><i class="ti ti-pencil me-1"></i> Edit</a>
                                <form action="{{ route('admin.kesiswaan.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini? Semua data terkait (tagihan, pembayaran) juga akan terhapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item"><i class="ti ti-trash me-1"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
