@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan / Data Siswa /</span> Edit Siswa</h4>

<form action="{{ route('admin.kesiswaan.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if ($errors->any())
        <div class="alert alert-danger">
            <h5 class="alert-heading">Terjadi Kesalahan!</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                    <label for="foto" class="form-label">Foto Siswa</label>
                    <div class="mb-3">
                        {{-- === AWAL PERUBAHAN: LOGIKA PLACEHOLDER BARU === --}}
                        @php
                            $namaParts = explode(' ', $siswa->nama);
                            $initials = count($namaParts) > 1 
                                ? strtoupper(substr($namaParts[0], 0, 1) . substr(end($namaParts), 0, 1))
                                : strtoupper(substr($siswa->nama, 0, 2));
                            
                            $photoUrl = $siswa->foto 
                                ? asset('storage/' . $siswa->foto) 
                                : 'https://placehold.co/150x150/696cff/FFFFFF?text=' . $initials;
                        @endphp
                        <img id="foto-preview" src="{{ $photoUrl }}" alt="Foto Siswa" class="img-fluid rounded" style="width: 150px; height: 150px; object-fit: cover;">
                        {{-- === AKHIR PERUBAHAN === --}}
                    </div>
                    <input type="file" class="form-control" id="foto" name="foto" onchange="previewImage()">
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Data Diri Siswa</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                                <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $siswa->nik) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="agama_id_str" class="form-label">Agama</label>
                            <input type="text" class="form-control" id="agama_id_str" name="agama_id_str" value="{{ old('agama_id_str', $siswa->agama_id_str) }}">
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $siswa->nomor_hp) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $siswa->email) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Data Alamat</h5></div>
        <div class="card-body">
            <div class="mb-3">
                <label for="alamat_jalan" class="form-label">Alamat Jalan</label>
                <textarea class="form-control" id="alamat_jalan" name="alamat_jalan" rows="2">{{ old('alamat_jalan', $siswa->alamat_jalan) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-3 mb-3"><label for="rt" class="form-label">RT</label><input type="text" class="form-control" id="rt" name="rt" value="{{ old('rt', $siswa->rt) }}"></div>
                <div class="col-md-3 mb-3"><label for="rw" class="form-label">RW</label><input type="text" class="form-control" id="rw" name="rw" value="{{ old('rw', $siswa->rw) }}"></div>
                <div class="col-md-6 mb-3"><label for="nama_dusun" class="form-label">Nama Dusun</label><input type="text" class="form-control" id="nama_dusun" name="nama_dusun" value="{{ old('nama_dusun', $siswa->nama_dusun) }}"></div>
                <div class="col-md-4 mb-3"><label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label><input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan', $siswa->desa_kelurahan) }}"></div>
                <div class="col-md-4 mb-3"><label for="kecamatan" class="form-label">Kecamatan</label><input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $siswa->kecamatan) }}"></div>
                <div class="col-md-4 mb-3"><label for="kode_pos" class="form-label">Kode Pos</label><input type="text" class="form-control" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $siswa->kode_pos) }}"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Data Ayah & Ibu</h5></div>
                <div class="card-body">
                    <h6>Data Ayah</h6><hr>
                    <div class="mb-3"><label for="nama_ayah" class="form-label">Nama Ayah</label><input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}"></div>
                    <div class="mb-3"><label for="nik_ayah" class="form-label">NIK Ayah</label><input type="text" class="form-control" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah', $siswa->nik_ayah) }}"></div>
                    <div class="mb-3"><label for="pekerjaan_ayah_id_str" class="form-label">Pekerjaan Ayah</label><input type="text" class="form-control" id="pekerjaan_ayah_id_str" name="pekerjaan_ayah_id_str" value="{{ old('pekerjaan_ayah_id_str', $siswa->pekerjaan_ayah_id_str) }}"></div>
                    <h6 class="mt-4">Data Ibu</h6><hr>
                    <div class="mb-3"><label for="nama_ibu_kandung" class="form-label">Nama Ibu</label><input type="text" class="form-control" id="nama_ibu_kandung" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $siswa->nama_ibu_kandung) }}"></div>
                    <div class="mb-3"><label for="nik_ibu" class="form-label">NIK Ibu</label><input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu', $siswa->nik_ibu) }}"></div>
                    <div class="mb-3"><label for="pekerjaan_ibu_id_str" class="form-label">Pekerjaan Ibu</label><input type="text" class="form-control" id="pekerjaan_ibu_id_str" name="pekerjaan_ibu_id_str" value="{{ old('pekerjaan_ibu_id_str', $siswa->pekerjaan_ibu_id_str) }}"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0">Data Wali</h5></div>
                <div class="card-body">
                    <div class="mb-3"><label for="nama_wali" class="form-label">Nama Wali</label><input type="text" class="form-control" id="nama_wali" name="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali) }}"></div>
                    <div class="mb-3"><label for="nik_wali" class="form-label">NIK Wali</label><input type="text" class="form-control" id="nik_wali" name="nik_wali" value="{{ old('nik_wali', $siswa->nik_wali) }}"></div>
                    <div class="mb-3"><label for="pekerjaan_wali_id_str" class="form-label">Pekerjaan Wali</label><input type="text" class="form-control" id="pekerjaan_wali_id_str" name="pekerjaan_wali_id_str" value="{{ old('pekerjaan_wali_id_str', $siswa->pekerjaan_wali_id_str) }}"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="my-4">
        <button type="submit" class="btn btn-primary">Simpan Semua Perubahan</button>
        <a href="{{ route('admin.kesiswaan.siswa.index') }}" class="btn btn-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan preview gambar sebelum di-upload
    function previewImage() {
        const fileInput = document.getElementById('foto');
        const preview = document.getElementById('foto-preview');
        
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>
@endpush