@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Indisipliner / Siswa /</span> Daftar Indisipliner</h4>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    {{-- Header dengan Judul dan Tombol Aksi --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pelanggaran Siswa</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalInputPelanggaran">
            <i class="bx bx-plus me-1"></i> Input Pelanggaran
        </button>
    </div>

    {{-- Panel Filter --}}
    <div class="card-body border-top">
        <form action="{{ route('admin.indisipliner.siswa.daftar.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label" for="rombel_id_filter">Filter Berdasarkan Kelas</label>
                    <select name="rombel_id" id="rombel_id_filter" class="form-select">
                        <option value="">- Semua Kelas -</option>
                        @foreach($rombels as $rombel)
                            <option value="{{ $rombel->id }}" {{ request('rombel_id') == $rombel->id ? 'selected' : '' }}>{{ $rombel->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="nis_filter">Filter Berdasarkan Siswa</label>
                    <select name="nis" id="nis_filter" class="form-select">
                        <option value="">- Pilih Kelas Terlebih Dahulu -</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="search_filter">Cari Nama/NIPD</label>
                    <input type="search" class="form-control" name="search" id="search_filter" placeholder="Ketik di sini..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary w-100"><i class="bx bx-search"></i> Cari</button>
                    <a href="{{ route('admin.indisipliner.siswa.daftar.index') }}" class="btn btn-outline-secondary" title="Reset Filter"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel Riwayat Pelanggaran --}}
    <div class="table-responsive text-nowrap">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>NIPD</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Pelanggaran</th>
                    <th>Tanggal & Waktu</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($pelanggaranList as $key => $pelanggaran)
                <tr>
                    <td>{{ $pelanggaranList->firstItem() + $key }}</td>
                    <td>{{ $pelanggaran->NIS }}</td>
                    <td><strong>{{ $pelanggaran->siswa->nama ?? 'Siswa Dihapus' }}</strong></td>
                    <td>{{ $pelanggaran->rombel->nama ?? '-' }}</td>
                    <td style="white-space: normal; min-width: 250px;">{{ $pelanggaran->detailPoin->nama ?? 'Tidak Diketahui' }}</td>
                    <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d M Y') }}, {{ $pelanggaran->jam }}</td>
                    <td><span class="badge bg-danger rounded-pill">{{ $pelanggaran->poin }}</span></td>
                    <td>
                        <form action="{{ route('admin.indisipliner.siswa.daftar.destroy', $pelanggaran->ID) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" title="Hapus Data" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <i class="bx bx-info-circle bx-lg text-muted mb-2"></i>
                        <p class="text-muted mb-0">Tidak ada data pelanggaran untuk ditampilkan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Footer dengan Paginasi --}}
    <div class="card-footer d-flex justify-content-between align-items-center">
        @if($pelanggaranList->total() > 0)
        <small class="text-muted">Menampilkan {{ $pelanggaranList->firstItem() }} sampai {{ $pelanggaranList->lastItem() }} dari {{ $pelanggaranList->total() }} hasil</small>
        @endif
        {{ $pelanggaranList->links() }}
    </div>
</div>

{{-- Memanggil Modal dari file terpisah --}}
@include('admin.indisipliner.siswa.daftar._modal-form')

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - Initializing siswa filter');
    
    const rombelFilter = document.getElementById('rombel_id_filter');
    const nisFilter = document.getElementById('nis_filter');
    const modalRombel = document.getElementById('IDkelas');
    const modalNis = document.getElementById('NIS');

    // Fungsi untuk memuat siswa
    function loadSiswa(rombelId, targetSelect, isFilter = true) {
        console.log('Loading siswa for rombel:', rombelId);
        
        if (!rombelId) {
            targetSelect.innerHTML = '<option value="">- Pilih Kelas Terlebih Dahulu -</option>';
            targetSelect.disabled = true;
            return;
        }

        // Show loading
        targetSelect.innerHTML = '<option value="">- Memuat Siswa... -</option>';
        targetSelect.disabled = true;

        // ✅ PERBAIKAN: Gunakan URL langsung untuk menghindari error route
        const url = `/admin/indisipliner/siswa/get-siswa-by-rombel/${rombelId}`;
        console.log('Fetching from:', url);

        fetch(url)
            .then(response => {
                console.log('Response status:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                
                let options = '';
                
                if (isFilter) {
                    options = '<option value="">- Semua Siswa -</option>';
                } else {
                    options = '<option value="">- Pilih Siswa -</option>';
                }

                if (data && data.length > 0) {
                    data.forEach(siswa => {
                        options += `<option value="${siswa.nipd}">${siswa.nama} (${siswa.nipd})</option>`;
                    });
                    targetSelect.disabled = false;
                    console.log(`Loaded ${data.length} students`);
                } else {
                    options = '<option value="">- Tidak ada siswa -</option>';
                    targetSelect.disabled = true;
                    console.log('No students found');
                }
                
                targetSelect.innerHTML = options;
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                targetSelect.innerHTML = '<option value="">- Error memuat data -</option>';
                targetSelect.disabled = true;
            });
    }

    // Event listeners
    if (rombelFilter) {
        rombelFilter.addEventListener('change', function() {
            const rombelId = this.value;
            console.log('Filter rombel changed to:', rombelId);
            loadSiswa(rombelId, nisFilter, true);
        });

        // Load initial data
        const initialRombelId = rombelFilter.value;
        if (initialRombelId) {
            console.log('Initial rombel found:', initialRombelId);
            loadSiswa(initialRombelId, nisFilter, true);
        }
    }

    if (modalRombel) {
        modalRombel.addEventListener('change', function() {
            const rombelId = this.value;
            console.log('Modal rombel changed to:', rombelId);
            loadSiswa(rombelId, modalNis, false);
        });
    }

    console.log('Siswa filter initialized successfully');
});
</script>
@endpush