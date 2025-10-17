@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Jadwal Pelajaran /</span> Pilih Kelas
</h4>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Silakan Pilih Kelas untuk Mengatur Jadwal</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            @forelse ($rombels as $rombel)
                <a href="{{ route('admin.jadwal-pelajaran.create', $rombel->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bx bx-buildings me-2"></i>
                        {{ $rombel->nama }}
                    </span>
                    <span class="badge bg-primary">Atur Jadwal <i class="bx bx-right-arrow-alt"></i></span>
                </a>
            @empty
                <p class="text-center">Tidak ada data rombongan belajar ditemukan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection