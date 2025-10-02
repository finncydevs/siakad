@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Indisipliner / Siswa /</span> Daftar Indisipliner</h4>

{{-- Menampilkan notifikasi sukses --}}
@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="card-title mb-2 mb-md-0">Riwayat Pelanggaran Siswa</h5>
            <div class="d-flex">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputPelanggaran">
                    <i class="bx bx-plus me-1"></i> Input Pelanggaran
                </button>
            </div>
        </div>
        <hr class="my-3">
        {{-- Form Filter --}}
        <form action="{{ route('admin.indisipliner.siswa.daftar.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="rombel_id" class="form-label">Filter Kelas</label>
                    <select name="rombel_id" id="rombel_id" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($rombels as $id => $nama)
                            <option value="{{ $id }}" {{ request('rombel_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                </div>
                <div class="col-md-3">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Pelanggaran</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($pelanggaranList as $key => $pelanggaran)
                <tr>
                    <td>{{ $pelanggaranList->firstItem() + $key }}</td>
                    <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d M Y') }}</td>
                    <td><strong>{{ $pelanggaran->siswa->nama ?? 'Siswa tidak ditemukan' }}</strong><br><small class="text-muted">NIS: {{ $pelanggaran->NIS }}</small></td>
                    <td>{{ $pelanggaran->rombel->nama ?? '-' }}</td>
                    <td style="white-space: normal;">{{ $pelanggaran->detailPoin->nama ?? 'Tidak diketahui' }}</td>
                    <td><span class="badge bg-label-danger rounded-pill">{{ $pelanggaran->poin }}</span></td>
                    <td>
                        <form action="{{ route('admin.indisipliner.siswa.daftar.destroy', $pelanggaran->ID) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Data">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                         <i class="bx bx-info-circle bx-lg text-muted mb-2"></i>
                        <p class="text-muted">Tidak ada data pelanggaran untuk ditampilkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $pelanggaranList->appends(request()->query())->links() }}
    </div>
</div>

<!-- Modal Input Pelanggaran -->
<div class="modal fade" id="modalInputPelanggaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Pelanggaran Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.indisipliner.siswa.daftar.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="NIS" class="form-label">Siswa</label>
                        <select name="NIS" id="NIS" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswaList as $siswa)
                                <option value="{{ $siswa->nis }}">{{ $siswa->nama }} ({{ $siswa->nis }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="IDpelanggaran_poin" class="form-label">Jenis Pelanggaran</label>
                        <select name="IDpelanggaran_poin" id="IDpelanggaran_poin" class="form-select" required>
                            <option value="">Pilih Jenis Pelanggaran</option>
                            @foreach ($kategoriList as $kategori)
                                <optgroup label="{{ strtoupper($kategori->nama) }}">
                                    @foreach ($kategori->pelanggaranPoin as $poin)
                                        <option value="{{ $poin->ID }}">{{ $poin->nama }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi Tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Konfirmasi Hapus
        const deleteForms = document.querySelectorAll('.form-delete');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus data pelanggaran ini?')) {
                    this.submit();
                }
            });
        });
    });
</script>
@endpush

