@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Data Pegawai</h4>

@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Pengelolaan data Pegawai</h5>
        <a href="{{ route('admin.kepegawaian.pegawai.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Data
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Pegawai</th>
                    <th>L/P</th>
                    <th>Tipe Pegawai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($pegawais as $key => $pegawai)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : 'https://placehold.co/45x60?text=Foto' }}" alt="Foto Pegawai" class="rounded" style="width: 45px; height: 60px; object-fit: cover;">
                    </td>
                    <td>
                        <strong>{{ $pegawai->nama_lengkap }}</strong><br>
                        <small>NIP/NIY: {{ $pegawai->nip ?? $pegawai->niy_nigk ?? '-' }}</small>
                    </td>
                    <td>{{ $pegawai->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                    <td>
                        <span class="badge bg-label-info me-1">{{ $pegawai->tugasTerbaru->tugas_pokok ?? 'Belum ada tugas' }}</span>
                    </td>
                    <td><span class="badge bg-label-success me-1">{{ $pegawai->status }}</span></td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-icon btn-sm btn-outline-secondary me-1" href="{{ route('admin.kepegawaian.pegawai.show', $pegawai->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                <i class="bx bx-show"></i>
                            </a>
                            <a class="btn btn-icon btn-sm btn-outline-primary me-1" href="{{ route('admin.kepegawaian.pegawai.edit', $pegawai->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <form action="{{ route('admin.kepegawaian.pegawai.destroy', $pegawai->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
