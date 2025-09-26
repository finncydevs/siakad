@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Profil Sekolah</h4>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Detail Profil Sekolah</h5>
            <!-- Form -->
            {{-- PERBAIKAN DI SINI --}}
            <form action="{{ route('admin.pengaturan.profil_sekolah.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profil" aria-controls="navs-profil" aria-selected="true">
                                    <i class="tf-icons bx bx-user"></i> Profil
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-gambar" aria-controls="navs-gambar" aria-selected="false">
                                    <i class="tf-icons bx bx-image"></i> Gambar
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-alamat" aria-controls="navs-alamat" aria-selected="false">
                                    <i class="tf-icons bx bx-map-alt"></i> Alamat
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-peta" aria-controls="navs-peta" aria-selected="false">
                                    <i class="tf-icons bx bx-map"></i> Peta
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            {{-- TAB PROFIL --}}
                            <div class="tab-pane fade show active" id="navs-profil" role="tabpanel">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="nama_instansi" class="form-label">Nama Instansi</label>
                                        <input class="form-control form-control-sm" type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi', $profil->nama_instansi) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="bidang_studi" class="form-label">Bidang Studi</label>
                                        <input class="form-control form-control-sm" type="text" id="bidang_studi" name="bidang_studi" value="{{ old('bidang_studi', $profil->bidang_studi) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="singkatan" class="form-label">Singkatan / Inisial</label>
                                        <input class="form-control form-control-sm" type="text" name="singkatan" id="singkatan" value="{{ old('singkatan', $profil->singkatan) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                                        <input class="form-control form-control-sm" type="text" name="tahun_berdiri" id="tahun_berdiri" value="{{ old('tahun_berdiri', $profil->tahun_berdiri) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <input class="form-control form-control-sm" type="text" id="status" name="status" value="{{ old('status', $profil->status) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="nss" class="form-label">NSS</label>
                                        <input class="form-control form-control-sm" type="text" id="nss" name="nss" value="{{ old('nss', $profil->nss) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="nama_kepala_sekolah" class="form-label">Nama Kepala Sekolah</label>
                                        <input class="form-control form-control-sm" type="text" id="nama_kepala_sekolah" name="nama_kepala_sekolah" value="{{ old('nama_kepala_sekolah', $profil->nama_kepala_sekolah) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="npsn" class="form-label">NPSN</label>
                                        <input class="form-control form-control-sm" type="text" id="npsn" name="npsn" value="{{ old('npsn', $profil->npsn) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="nip_kepala_sekolah" class="form-label">NIP Kepala Sekolah</label>
                                        <input class="form-control form-control-sm" type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $profil->nip_kepala_sekolah) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="luas" class="form-label">Luas</label>
                                        <input class="form-control form-control-sm" type="text" id="luas" name="luas" value="{{ old('luas', $profil->luas) }}">
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="moto" class="form-label">Moto</label>
                                        <textarea class="form-control form-control-sm" name="moto" id="moto" rows="3">{{ old('moto', $profil->moto) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- TAB GAMBAR --}}
                            <div class="tab-pane fade" id="navs-gambar" role="tabpanel">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input class="form-control form-control-sm" type="file" id="logo" name="logo">
                                        @if($profil->logo)
                                            <div class="mt-3">
                                                <img src="{{ asset('storage/' . $profil->logo) }}" alt="Logo" class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="icon" class="form-label">Icon</label>
                                        <input class="form-control form-control-sm" type="file" id="icon" name="icon">
                                        @if($profil->icon)
                                            <div class="mt-3">
                                                <img src="{{ asset('storage/' . $profil->icon) }}" alt="Icon" class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- TAB ALAMAT --}}
                            <div class="tab-pane fade" id="navs-alamat" role="tabpanel">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control form-control-sm" id="alamat" name="alamat" rows="3">{{ old('alamat', $profil->alamat) }}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="desa" class="form-label">Desa/Kelurahan</label>
                                        <input class="form-control form-control-sm" type="text" id="desa" name="desa" value="{{ old('desa', $profil->desa) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input class="form-control form-control-sm" type="text" id="telepon" name="telepon" value="{{ old('telepon', $profil->telepon) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="kecamatan" class="form-label">Kecamatan</label>
                                        <input class="form-control form-control-sm" type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $profil->kecamatan) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="faximile" class="form-label">Faximile</label>
                                        <input class="form-control form-control-sm" type="text" id="faximile" name="faximile" value="{{ old('faximile', $profil->faximile) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="kabupaten" class="form-label">Kabupaten</label>
                                        <input class="form-control form-control-sm" type="text" id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $profil->kabupaten) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input class="form-control form-control-sm" type="email" id="email" name="email" value="{{ old('email', $profil->email) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="provinsi" class="form-label">Provinsi</label>
                                        <input class="form-control form-control-sm" type="text" id="provinsi" name="provinsi" value="{{ old('provinsi', $profil->provinsi) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="website" class="form-label">Situs/Website</label>
                                        <input class="form-control form-control-sm" type="text" id="website" name="website" value="{{ old('website', $profil->website) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="kode_pos" class="form-label">Kode Pos</label>
                                        <input class="form-control form-control-sm" type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $profil->kode_pos) }}">
                                    </div>
                                </div>
                            </div>
                            {{-- TAB PETA --}}
                            <div class="tab-pane fade" id="navs-peta" role="tabpanel">
                                <div class="mb-3 col-md-12">
                                    <label for="embed_peta" class="form-label">Embed Peta Google Maps</label>
                                    <textarea class="form-control form-control-sm" id="embed_peta" name="embed_peta" rows="5">{{ old('embed_peta', $profil->embed_peta) }}</textarea>
                                    <div class="form-text">Tempelkan kode embed dari Google Maps di sini (biasanya diawali dengan &lt;iframe&gt;).</div>
                                </div>
                                <div class="mt-3">
                                    <h5>Pratinjau Peta:</h5>
                                    @if($profil->embed_peta)
                                        <div class="w-100" style="height: 400px;">
                                            {!! $profil->embed_peta !!}
                                        </div>
                                    @else
                                        <p>Belum ada peta yang disematkan.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
            <!-- /Form -->
        </div>
    </div>
</div>
@endsection
    