@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kepegawaian / Data Pegawai /</span> Detail Pegawai</h4>

<div class="row">
    <!-- Kolom Kiri: Foto & Tombol Aksi -->
    <div class="col-xl-4 col-lg-5 col-md-5">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ $pegawai->foto ? asset('storage/' . $pegawai->foto) : 'https://placehold.co/300x400?text=Foto' }}"
                         alt="Foto Pegawai"
                         class="img-fluid rounded mb-3"
                         style="width: 200px; height: 267px; object-fit: cover; aspect-ratio: 3/4;">
                    <div class="mt-3">
                        <h4 class="mb-0">{{ $pegawai->nama_lengkap }}</h4>
                        <p class="text-muted font-size-sm">{{ $pegawai->tipe_pegawai ?? 'Pegawai' }}</p>
                        <a href="{{ route('admin.pegawai.edit', $pegawai->id) }}" class="btn btn-primary">Edit Profil</a>
                        <a href="{{ route('admin.pegawai.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Detail dengan Tab -->
    <div class="col-xl-8 col-lg-7 col-md-7">
        <div class="card mb-4">
            <div class="card-body">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-data-diri" aria-controls="navs-data-diri" aria-selected="true">
                                <i class="tf-icons bx bx-user me-1"></i> Data Diri
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-kepegawaian" aria-controls="navs-kepegawaian" aria-selected="false">
                                <i class="tf-icons bx bx-briefcase me-1"></i> Kepegawaian
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-penugasan" aria-controls="navs-penugasan" aria-selected="false">
                                <i class="tf-icons bx bx-file-blank me-1"></i> Penugasan
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Tab Data Diri -->
                        <div class="tab-pane fade show active" id="navs-data-diri" role="tabpanel">
                            <dl class="row mt-3">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: {{ $pegawai->gelar_depan }} {{ $pegawai->nama_lengkap }} {{ $pegawai->gelar_belakang }}</dd>

                                <dt class="col-sm-4">Tempat, Tanggal Lahir</dt>
                                <dd class="col-sm-8">: {{ $pegawai->tempat_lahir ?? '-' }}, {{ $pegawai->tanggal_lahir ? \Carbon\Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: {{ $pegawai->jenis_kelamin ?? '-' }}</dd>
                                
                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">: {{ $pegawai->agama ?? '-' }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: {{ $pegawai->alamat ?? '-' }}, {{ $pegawai->desa ?? '' }}, {{ $pegawai->kecamatan ?? '' }}, {{ $pegawai->kabupaten ?? '' }}, {{ $pegawai->provinsi ?? '' }} {{ $pegawai->kode_pos ?? '' }}</dd>

                                <dt class="col-sm-4">Kontak / Telepon</dt>
                                <dd class="col-sm-8">: {{ $pegawai->kontak ?? '-' }}</dd>
                                
                                <dt class="col-sm-4">Status Pernikahan</dt>
                                <dd class="col-sm-8">: {{ $pegawai->status_pernikahan ?? '-' }}</dd>

                                <dt class="col-sm-4">Nama Pasangan</dt>
                                <dd class="col-sm-8">: {{ $pegawai->nama_pasangan ?? '-' }}</dd>

                                <dt class="col-sm-4">Jumlah Anak</dt>
                                <dd class="col-sm-8">: {{ $pegawai->jumlah_anak ?? '-' }}</dd>
                            </dl>
                        </div>
                        <!-- Tab Kepegawaian -->
                        <div class="tab-pane fade" id="navs-kepegawaian" role="tabpanel">
                             <dl class="row mt-3">
                                <dt class="col-sm-4">Status Kepegawaian</dt>
                                <dd class="col-sm-8">: <span class="badge bg-label-success">{{ $pegawai->status ?? '-' }}</span></dd>

                                <dt class="col-sm-4">Tipe Pegawai</dt>
                                <dd class="col-sm-8">: {{ $pegawai->tipe_pegawai ?? '-' }}</dd>

                                <dt class="col-sm-4">NIP</dt>
                                <dd class="col-sm-8">: {{ $pegawai->nip ?? '-' }}</dd>

                                <dt class="col-sm-4">NIY/NIGK</dt>
                                <dd class="col-sm-8">: {{ $pegawai->niy_nigk ?? '-' }}</dd>

                                <dt class="col-sm-4">NUPTK</dt>
                                <dd class="col-sm-8">: {{ $pegawai->nuptk ?? '-' }}</dd>

                                <dt class="col-sm-4">NPWP</dt>
                                <dd class="col-sm-8">: {{ $pegawai->npwp ?? '-' }}</dd>

                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: {{ $pegawai->nik ?? '-' }}</dd>
                            </dl>
                        </div>
                        <!-- Tab Penugasan -->
                        <div class="tab-pane fade" id="navs-penugasan" role="tabpanel">
                             <dl class="row mt-3">
                                <dt class="col-sm-4">Tugas Pokok</dt>
                                <dd class="col-sm-8">: {{ $tugas ? $tugas->tugas_pokok : 'Belum ada data' }}</dd>

                                <dt class="col-sm-4">Nomor SK</dt>
                                <dd class="col-sm-8">: {{ $tugas ? $tugas->nomor_sk : '-' }}</dd>

                                <dt class="col-sm-4">TMT Tugas</dt>
                                <dd class="col-sm-8">: {{ $tugas && $tugas->tmt ? \Carbon\Carbon::parse($tugas->tmt)->translatedFormat('d F Y') : '-' }}</dd>

                                <dt class="col-sm-4">Jumlah Jam</dt>
                                <dd class="col-sm-8">: {{ $tugas ? $tugas->jumlah_jam : '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

