@extends('layouts.admin')

@section('content')
    {{-- Header Halaman --}}
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Rombongan Belajar /</span> Praktik
    </h4>

    {{-- Konten Card --}}
    <div class="card">
        {{-- Toolbar Aksi --}}
        <div class="card-header">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h5 class="card-title mb-2 mb-md-0">Data Rombel Praktik</h5>
                <div class="d-flex flex-wrap" style="gap: 0.5rem;">
                    <a href="{{ route('admin.rombel.praktik.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i> Tambah
                    </a>
                    <button type="button" class="btn btn-secondary"><i class="bx bx-pencil me-1"></i> Ubah</button>
                    <button type="button" class="btn btn-success"><i class="bx bx-save me-1"></i> Simpan</button>
                    <button type="button" class="btn btn-danger"><i class="bx bx-trash me-1"></i> Hapus</button>
                </div>
            </div>
        </div>
        
        {{-- Div untuk tabel responsif --}}
        <div class="table-responsive text-nowrap"> 
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 1%;"><input class="form-check-input" type="checkbox" id="selectAll"></th>
                        <th>Tingkat Pendidikan</th>
                        <th>Prog/Komp Keahlian</th>
                        <th>Kurikulum</th>
                        <th>Nama Rombel</th>
                        <th>Wali/Guru Kelas</th>
                        <th>Ruang</th>
                        <th>Moving Class</th>
                        <th>Kebutuhan Khusus</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($rombels as $rombel)
                        {{-- Baris ini tidak akan ditampilkan karena data kosong --}}
                        <tr>
                            <td><input class="form-check-input row-checkbox" type="checkbox"></td>
                            <td>{{ $rombel['tingkat'] }}</td>
                            <td>{{ $rombel['jurusan'] }}</td>
                            <td>{{ $rombel['kurikulum'] }}</td>
                            <td><strong>{{ $rombel['nama_rombel'] }}</strong></td>
                            <td>{{ $rombel['wali'] }}</td>
                            <td>{{ $rombel['ruang'] }}</td>
                            <td>{!! $rombel['moving'] == 'Ya' ? '<span class="badge bg-label-success">Ya</span>' : '<span class="badge bg-label-secondary">Tidak</span>' !!}</td>
                            <td>{!! $rombel['kebutuhan_khusus'] == 'Ya' ? '<span class="badge bg-label-info">Ya</span>' : '<span class="badge bg-label-secondary">Tidak</span>' !!}</td>
                        </tr>
                    @empty
                        {{-- Tampilan jika data kosong --}}
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data rombel praktik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Link Paginasi --}}
        <div class="card-footer">
            {{ $rombels->links() }}
        </div>
    </div>
@endsection

@push('scripts')
{{-- Script untuk fungsionalitas checkbox "select all" --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');

        selectAllCheckbox.addEventListener('change', function () {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });
</script>
@endpush