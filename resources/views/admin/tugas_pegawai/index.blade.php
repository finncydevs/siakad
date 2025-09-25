        @extends('layouts.admin')

        @section('content')
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kepegawaian /</span> Tugas Pegawai</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <h5 class="card-header">Formulir</h5>
                    <div class="card-body">
                        <form action="{{ route('tugas-pegawai.store') }}" method="POST">
                            @csrf
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
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="reset" class="btn btn-outline-secondary">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
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
                                @foreach ($tugasPegawais as $key => $tugas)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <strong>{{ $tugas->pegawai->nama_lengkap }}</strong><br>
                                            <small>{{ $tugas->pegawai->nip ?? $tugas->pegawai->niy_nigk }}</small>
                                        </td>
                                        <td>{{ $tugas->tugas_pokok }}</td>
                                        <td>{{ $tugas->jumlah_jam }}</td>
                                        <td>
                                            <small>
                                                TMT: {{ \Carbon\Carbon::parse($tugas->tmt)->format('d-m-Y') }}<br>
                                                No. SK: {{ $tugas->nomor_sk }}
                                            </small>
                                        </td>
                                        <td>
                                            <form action="{{ route('tugas-pegawai.destroy', $tugas->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-icon btn-sm btn-outline-danger">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        
