@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Data Guru & Tenaga Kependidikan</h4>

<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Daftar GTK</h5>
            <div class="d-flex gap-2">
                {{-- Tombol ini akan muncul jika ada checkbox yang dipilih --}}
                <button id="exportSelectedBtn" class="btn btn-secondary btn-sm" style="display: none;" onclick="exportSelected()">
                    <i class="bx bx-export me-1"></i> Export yang Dipilih
                </button>
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-export me-1"></i> Opsi Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('admin.kepegawaian.gtk.export.excel') }}">Export Semua</a></li>
                        <li><a class="dropdown-item" href="#">PDF (Segera Hadir)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kepegawaian.gtk.index') }}" method="GET">
            <div class="input-group input-group-merge">
                <span class="input-group-text"><i class="bx bx-search"></i></span>
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan Nama, NIP, atau NIK..." value="{{ request('search') }}">
            </div>
        </form>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><input class="form-check-input" type="checkbox" id="selectAllCheckbox"></th>
                    <th>NAMA LENGKAP</th>
                    <th>NIP</th>
                    <th>JENIS PTK</th>
                    <th>STATUS KEPEGAWAIAN</th>
                    <th class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($gtks as $gtk)
                <tr>
                    <td><input class="form-check-input row-checkbox" type="checkbox" value="{{ $gtk->id }}"></td>
                    <td>
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="avatar-wrapper">
                                <div class="avatar me-3">
                                    <span class="avatar-initial rounded-circle bg-label-info">{{ substr($gtk->nama, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">{{ $gtk->nama }}</span>
                                <small class="text-muted">NIK: {{ $gtk->nik ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $gtk->nip ?? '-' }}</td>
                    <td>{{ $gtk->jenis_ptk_id_str ?? '-' }}</td>
                    <td>
                        <span class="badge bg-label-success">{{ $gtk->status_kepegawaian_id_str ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                       <a href="{{ route('admin.kepegawaian.gtk.show', $gtk->id) }}" class="btn btn-sm btn-icon item-edit"><i class="bx bxs-show"></i></a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <i class="bx bx-user-x bx-lg text-muted d-block mx-auto mb-2"></i>
                        <span class="text-muted">Tidak ada data GTK untuk ditampilkan.</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($gtks->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $gtks->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const exportSelectedBtn = document.getElementById('exportSelectedBtn');

        function toggleExportButton() {
            const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            exportSelectedBtn.style.display = anyChecked ? 'inline-block' : 'none';
        }

        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleExportButton();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                }
                toggleExportButton();
            });
        });
    });

    function exportSelected() {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
                               .map(cb => cb.value)
                               .join(',');

        if (selectedIds) {
            const url = `{{ route('admin.kepegawaian.gtk.export.excel') }}?ids=${selectedIds}`;
            window.location.href = url;
        } else {
            alert('Silakan pilih setidaknya satu data untuk di-export.');
        }
    }
</script>
@endpush

