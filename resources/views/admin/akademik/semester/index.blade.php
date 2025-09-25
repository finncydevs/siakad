@extends('layouts.admin') 

{{-- Section untuk menempatkan skrip JavaScript (opsional, tergantung layout Anda) --}}
@section('scripts') 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Skrip untuk mengaktifkan semester (tombol power)
        const toggleForms = document.querySelectorAll('.toggle-form');
        toggleForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                // Konfirmasi sebelum mengirim PATCH request untuk mengaktifkan
                if (!confirm('Apakah Anda yakin ingin mengaktifkan semester ini? Semester lain akan dinonaktifkan secara otomatis.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Master Semester</h4>
    <p class="text-muted">Kelola data semester sekolah.</p>
    
    <div class="card">
        <h5 class="card-header">Daftar Semester</h5>
        <div class="card-body">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="p-3 mb-3 bg-light rounded">
                <p class="mb-1"><strong>Informasi:</strong></p>
                <ol class="list-unstyled mb-0">
                    <li><i class="bx bx-check-square text-success"></i> adalah semester yang aktif</li>
                    <li><i class="bx bx-power-off text-info"></i> untuk mengaktifkan semester</li>
                </ol>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>SEMESTER</th>
                            <th>KETERANGAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($semesters as $semester)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($semester->is_active)
                                        <span class="badge bg-label-success me-1">{{ $semester->nama }}</span>
                                    @else
                                        {{ $semester->nama }}
                                    @endif
                                </td>
                                <td>{{ $semester->keterangan ?? '-' }}</td>
                                <td>
                                    @if ($semester->is_active)
                                        {{-- Icon jika aktif --}}
                                        <i class="bx bx-check-square text-success" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Semester Aktif"></i>
                                    @else
                                        {{-- Tombol Toggle Aktif (PATCH) --}}
                                        <form action="{{ route('admin.akademik.semester.toggle', $semester->id) }}" method="POST" class="d-inline toggle-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-icon btn-sm text-info" 
                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                    title="Aktifkan Semester">
                                                <i class="bx bx-power-off"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data semester belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection