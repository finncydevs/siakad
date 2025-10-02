    @extends('layouts.admin')

    @section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan /</span> Data Siswa</h4>
    
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <form action="{{ route('admin.kesiswaan.siswa.index') }}" method="GET" class="d-flex">
                    <select name="kelas_id" class="form-select me-2">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $id => $nama)
                        <option value="{{ $id }}" {{ request('kelas_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </form>
                <a href="{{ route('admin.kesiswaan.siswa.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Tambah Siswa
                </a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>L/P</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($siswas as $key => $siswa)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $siswa->nis ?? '-' }}</td>
                        <td>{{ $siswa->nisn ?? '-' }}</td>
                        <td>{{ $siswa->nik ?? '-' }}</td>
                        <td><strong>{{ $siswa->nama}}</strong></td>
                        <td>{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                        <td>{{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                        <td><span class="badge bg-label-primary me-1">{{ $siswa->kelas_aktif_id ? $kelas[$siswa->kelas_aktif_id] : 'Belum ada kelas' }}</span></td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-icon btn-sm btn-outline-primary" href="{{ route('admin.kesiswaan.siswa.edit', $siswa->id) }}">
                                    <i class="bx bx-edit-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center">Tidak ada data untuk ditampilkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection
    
