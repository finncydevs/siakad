@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Pengaturan Absensi</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Atur Jam Sekolah & Toleransi</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form action="{{ route('admin.pengaturan.absensi.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="jam_masuk_sekolah" class="form-label">Jam Masuk Sekolah</label>
                        <input type="time" class="form-control" id="jam_masuk_sekolah" name="jam_masuk_sekolah" value="{{ $pengaturan->jam_masuk_sekolah }}">
                    </div>

                    <div class="mb-3">
                        <label for="jam_pulang_sekolah" class="form-label">Jam Pulang Sekolah</label>
                        <input type="time" class="form-control" id="jam_pulang_sekolah" name="jam_pulang_sekolah" value="{{ $pengaturan->jam_pulang_sekolah }}">
                    </div>

                    <div class="mb-3">
                        <label for="batas_toleransi_terlambat" class="form-label">Batas Toleransi Terlambat (Menit)</label>
                        <input type="number" class="form-control" id="batas_toleransi_terlambat" name="batas_toleransi_terlambat" value="{{ $pengaturan->batas_toleransi_terlambat }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection