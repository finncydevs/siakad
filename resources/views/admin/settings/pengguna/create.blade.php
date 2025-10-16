@extends('layouts.admin')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Manajemen Pengguna /</span> Tambah Baru
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulir Pengguna Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengguna.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="John Doe" value="{{ old('nama') }}" required />
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="johndoe" value="{{ old('username') }}" required />
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="peran_id_str" class="form-label">Peran (Role)</label>
                            <select class="form-select @error('peran_id_str') is-invalid @enderror" id="peran_id_str" name="peran_id_str" required>
                                <option value="" disabled selected>-- Pilih Peran --</option>
                                <option value="Admin" {{ old('peran_id_str') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Guru" {{ old('peran_id_str') == 'Guru' ? 'selected' : '' }}>Guru</option>
                                <option value="Peserta Didik" {{ old('peran_id_str') == 'Peserta Didik' ? 'selected' : '' }}>Siswa</option>
                            </select>
                            @error('peran_id_str')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required />
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required />
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection