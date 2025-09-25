@extends('layouts.admin') 
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akademik /</span> Tahun Pelajaran</h4>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <h5 class="card-header">Formulir</h5>
                <div class="card-body">
                    <form action="{{ route('admin.akademik.tapel.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                            <input type="text" class="form-control @error('tahun_pelajaran') is-invalid @enderror" id="tahun_pelajaran" name="tahun_pelajaran" value="{{ old('tahun_pelajaran') }}" placeholder="Contoh: 2025/2026">
                            @error('tahun_pelajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary me-2"><i class="bx bx-save"></i> Simpan</button>
                        <button type="reset" class="btn btn-secondary"><i class="bx bx-x"></i> Batal</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Daftar Tahun Pelajaran</h5>
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
                            <li><i class="bx bx-check-square text-success"></i> adalah tahun pelajaran yang aktif</li>
                            <li><i class="bx bx-power-off text-info"></i> untuk mengaktifkan tahun pelajaran</li>
                        </ol>
                    </div>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>TAHUN PELAJARAN</th>
                                    <th>KETERANGAN</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($tahun_pelajarans as $tp)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($tp->is_active)
                                                <span class="badge bg-label-success me-1">{{ $tp->tahun_pelajaran }}</span>
                                            @else
                                                {{ $tp->tahun_pelajaran }}
                                            @endif
                                        </td>
                                        <td>{{ $tp->keterangan ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                {{-- Tombol Toggle Aktif (PATCH) --}}
                                                <form action="{{ route('admin.akademik.tapel.toggle', $tp->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-icon btn-sm me-1 @if($tp->is_active) text-success @else text-info @endif" 
                                                            data-bs-toggle="tooltip" data-bs-placement="top" 
                                                            title="@if($tp->is_active) Tahun Aktif @else Aktifkan Tahun @endif" 
                                                            @if($tp->is_active) disabled @endif>
                                                        <i class="bx @if($tp->is_active) bx-check-square @else bx-power-off @endif"></i>
                                                    </button>
                                                </form>

                                                {{-- Tombol Hapus - MEMANGGIL MODAL --}}
                                                <button type="button" class="btn btn-icon btn-sm text-danger" 
                                                        data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal"
                                                        data-id="{{ $tp->id }}" 
                                                        data-name="{{ $tp->tahun_pelajaran }}"
                                                        title="Hapus"
                                                        @if($tp->is_active) disabled @endif>
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalTitle">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus Tahun Pelajaran <strong id="tapelName"></strong>?</p>
                    <div class="alert alert-warning" role="alert">
                        Tindakan ini tidak dapat dibatalkan.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
        // Pastikan modal dan Bootstrap JS sudah dimuat
        if (deleteConfirmationModal) {
            deleteConfirmationModal.addEventListener('show.bs.modal', function (event) {
                // Tombol yang memicu modal
                const button = event.relatedTarget; 
                
                // Ekstrak informasi dari atribut data-* pada tombol
                const tapelId = button.getAttribute('data-id');
                const tapelName = button.getAttribute('data-name');
                
                // Dapatkan elemen form dan tempat nama tahun pelajaran di modal
                const deleteForm = deleteConfirmationModal.querySelector('#deleteForm');
                const tapelNameStrong = deleteConfirmationModal.querySelector('#tapelName');
                
                // Update action URL pada form
                const routeUrl = '{{ route('admin.akademik.tapel.destroy', ':id') }}';
                deleteForm.action = routeUrl.replace(':id', tapelId);
                
                // Tampilkan nama tahun pelajaran di dalam modal
                tapelNameStrong.textContent = tapelName;
            });
        }
    });
</script>

@endsection