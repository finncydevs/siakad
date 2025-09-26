@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Tugas Pegawai</h4>



<div class="row">
    <!-- Kolom Form -->
    <div class="col-md-4">
        <div class="card mb-4">
            <h5 class="card-header" id="form-title">Formulir Tambah Data</h5>
            <div class="card-body">
                <form id="tugas-form" action="{{ route('admin.kepegawaian.tugas-pegawai.store') }}" method="POST">
                    @csrf
                    <div id="method-field"></div>
                    
                    <div class="mb-3">
                        <label for="tahun_pelajaran" class="form-label">Tahun Pelajaran</label>
                        <input type="text" class="form-control" id="tahun_pelajaran" name="tahun_pelajaran" value="2025/2026" required>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                     <div class="mb-3">
                        <label for="pegawai_id" class="form-label">Nama Pegawai</label>
                        <select class="form-select" id="pegawai_id" name="pegawai_id" required>
                            <option value="" disabled selected>- Pilih -</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id }}">{{ $pegawai->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tugas_pokok" class="form-label">Tugas Pokok</label>
                        <select class="form-select" id="tugas_pokok" name="tugas_pokok" required>
                            <option value="Pendidik">Pendidik</option>
                            <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" id="nomor_sk" name="nomor_sk">
                    </div>
                    <div class="mb-3">
                        <label for="tmt" class="form-label">Terhitung Mulai Tanggal (TMT)</label>
                        <input class="form-control" type="date" name="tmt" id="tmt">
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_jam" class="form-label">Jumlah Jam</label>
                        <input type="number" class="form-control" id="jumlah_jam" name="jumlah_jam" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="submit-button">Simpan</button>
                    <button type="button" class="btn btn-outline-secondary" id="cancel-button" onclick="resetForm()">Batal</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Kolom Tabel -->
    <div class="col-md-8">
        <div class="card">
             <h5 class="card-header">Daftar Tugas Pokok</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Tugas Pokok</th>
                            <th>Jumlah Jam</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($tugasPegawais as $key => $tugas)
                            <tr id="tugas-{{ $tugas->id }}" data-tugas='@json($tugas)'>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <strong>{{ $tugas->pegawai->nama_lengkap }}</strong><br>
                                    <small>{{ $tugas->pegawai->nip ?? $tugas->pegawai->niy_nigk }}</small>
                                </td>
                                <td>{{ $tugas->tugas_pokok }}</td>
                                <td>{{ $tugas->jumlah_jam }}</td>
                                <td>
                                    <small>
                                        TMT: {{ $tugas->tmt ? \Carbon\Carbon::parse($tugas->tmt)->format('d-m-Y') : '-' }}<br>
                                        No. SK: {{ $tugas->nomor_sk ?? '-' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-icon btn-sm btn-outline-primary me-1" onclick="editTugas({{ $tugas->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="bx bx-edit-alt"></i>
                                        </button>
                                        <form action="{{ route('admin.kepegawaian.tugas-pegawai.destroy', $tugas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data tugas pegawai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editTugas(id) {
        const tugasData = JSON.parse(document.getElementById('tugas-' + id).getAttribute('data-tugas'));
        
        document.getElementById('form-title').innerText = 'Formulir Edit Data';
        
        const form = document.getElementById('tugas-form');
        // PERBAIKAN: URL action untuk update disesuaikan dengan struktur rute baru
        form.action = `/admin/kepegawaian/tugas-pegawai/${id}`;
        
        document.getElementById('method-field').innerHTML = '@method("PUT")';

        document.getElementById('tahun_pelajaran').value = tugasData.tahun_pelajaran;
        document.getElementById('semester').value = tugasData.semester;
        document.getElementById('pegawai_id').value = tugasData.pegawai_id;
        document.getElementById('tugas_pokok').value = tugasData.tugas_pokok;
        document.getElementById('nomor_sk').value = tugasData.nomor_sk;
        document.getElementById('tmt').value = tugasData.tmt;
        document.getElementById('jumlah_jam').value = tugasData.jumlah_jam;
        document.getElementById('keterangan').value = tugasData.keterangan;
        
        document.getElementById('submit-button').innerText = 'Update';
        document.getElementById('cancel-button').style.display = 'inline-block';
    }

    function resetForm() {
        document.getElementById('form-title').innerText = 'Formulir Tambah Data';

        const form = document.getElementById('tugas-form');
        form.reset();
        // PERBAIKAN: URL action untuk store disesuaikan dengan struktur rute baru
        form.action = '{{ route("admin.kepegawaian.tugas-pegawai.store") }}';

        document.getElementById('method-field').innerHTML = '';

        document.getElementById('submit-button').innerText = 'Simpan';
    }
</script>
@endpush
