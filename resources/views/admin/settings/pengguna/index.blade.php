@extends('layouts.admin') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Pengaturan Sistem /</span> Manajemen Pengguna
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pengguna</h5>
            <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Pengguna
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Peran</th>
                        <th>Tgl Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($penggunas as $index => $pengguna)
                        <tr>
                            <td>{{ $penggunas->firstItem() + $index }}</td>
                            <td><strong>{{ $pengguna->nama }}</strong></td>
                            <td>{{ $pengguna->username }}</td>
                            <td><span class="badge bg-label-primary me-1">{{ $pengguna->peran_id_str }}</span></td>
                            <td>{{ $pengguna->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.pengguna.edit', $pengguna->id) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.pengguna.destroy', $pengguna->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                <i class="bx bx-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $penggunas->links() }}
        </div>
    </div>
</div>
@endsection