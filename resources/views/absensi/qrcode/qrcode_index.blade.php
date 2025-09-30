@extends('layouts.app') {{-- GANTI 'layouts.app' dengan nama file layout utama Anda --}}

@section('content')
    <div class="container-fluid">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Absensi /</span> Generate QR Code
        </h4>

        <div class="card">
            <h5 class="card-header">Daftar Guru, Tenaga Kependidikan, dan Siswa</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($users as $user)
                        <tr>
                            <td><strong>{{ $user->nama }}</strong></td>
                            <td>
                                @if ($user->role == 'GTK')
                                    <span class="badge bg-label-primary me-1">Guru/Tendik</span>
                                @else
                                    <span class="badge bg-label-success me-1">Siswa</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.absensi.qrcode.index', ['role' => $user->role, 'id' => $user->id]) }}"
                                   class="btn btn-sm btn-primary"
                                   target="_blank" {{-- Buka di tab baru --}}>
                                   <i class="bx bx-qr bx-xs"></i>&nbsp; Lihat QR Code
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3 px-4">
                {{-- Ini untuk navigasi halaman jika datanya ribuan --}}
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection