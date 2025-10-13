<!--
  This Blade partial generates the tabbed interface for the student data form.
  It's designed to be included in a parent view (like edit.blade.php).
  It expects a `$siswa` object to be passed for populating the form fields.
-->

<!-- Tab Navigation -->
<ul class="nav nav-tabs nav-pills flex-column flex-sm-row mb-4" role="tablist">
    <li class="nav-item">
        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#data-diri" aria-controls="data-diri" aria-selected="true">
            <i class="bx bx-user me-1"></i> Data Diri
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#alamat" aria-controls="alamat" aria-selected="false">
            <i class="bx bx-home me-1"></i> Alamat
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#data-orang-tua" aria-controls="data-orang-tua" aria-selected="false">
            <i class="bx bx-group me-1"></i> Data Orang Tua / Wali
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#akademik" aria-controls="akademik" aria-selected="false">
            <i class="bx bxs-graduation me-1"></i> Data Akademik
        </button>
    </li>
    <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#kesehatan" aria-controls="kesehatan" aria-selected="false">
            <i class="bx bx-health me-1"></i> Kesehatan
        </button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Data Diri Tab -->
    <div class="tab-pane fade show active" id="data-diri" role="tabpanel">
        <div class="row">
          <div class="col-md-4 mb-3">
                <label class="form-label">Foto Siswa</label>
                @if(isset($siswa) && $siswa->foto)
                    <img src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto Siswa" class="img-fluid rounded mb-2" style="max-height: 250px; width: 100%; object-fit: cover;">
                @else
                    <img src="https://placehold.co/400x400/EFEFEF/AAAAAA?text=Foto+Siswa" alt="Foto Siswa" class="img-fluid rounded mb-2">
                @endif
                <label for="foto" class="form-label">Ubah Foto</label>
                <input class="form-control" type="file" id="foto" name="foto">
                <div class="form-text">Kosongkan jika tidak ingin mengubah foto.</div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 mb-3">
    <label for="nama" class="form-label">Nama Lengkap</label>
    <input type="text" class="form-control" value="{{ $siswa->nama ?? '' }}" readonly>
    <input type="hidden" name="nama" value="{{ $siswa->nama ?? '' }}">
</div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status Siswa</label>
                        <input type="text" class="form-control" id="status" name="status" value="{{ old('status', $siswa->status ?? '') }}" readonly>
                    </div>
                   <div class="col-md-6 mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nipd" class="form-label">NIPD</label>
                        <input type="text" class="form-control" id="nipd" name="nipd" value="{{ old('nipd', $siswa->nipd ?? '') }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik', $siswa->nik ?? '') }}" readonly>
                    </div>
                  <div class="col-md-6 mb-3">
    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
    <input type="text" class="form-control" value="{{ $siswa->jenis_kelamin ?? '' }}" readonly>
    <input type="hidden" name="jenis_kelamin" value="{{ $siswa->jenis_kelamin ?? '' }}">
</div>
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}" readonly>
                    </div>
                      <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input
                            type="date"
                            class="form-control"
                            id="tanggal_lahir"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', optional($siswa->tanggal_lahir)->format('Y-m-d')) }}"
                            readonly>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="agama_id" class="form-label">Agama</label>
                        <input type="text" class="form-control" id="agama_id" name="agama_id" value="{{ old('agama_id', $siswa->agama_id ?? '') }}" readonly>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="anak_keberapa" class="form-label">Anak Ke-</label>
                        <input type="number" class="form-control" id="anak_keberapa" name="anak_keberapa" value="{{ old('anak_keberapa', $siswa->anak_keberapa ?? '') }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alamat Tab -->
    <div class="tab-pane fade" id="alamat" role="tabpanel">
        <div class="row">
            <div class="col-12 mb-3">
                <label for="alamat" class="form-label">Alamat Lengkap Siswa</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="4" readonly>{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomor_telepon_seluler" class="form-label">Nomor Telepon Seluler (HP)</label>
                <input type="text" class="form-control" id="nomor_telepon_seluler" name="nomor_telepon_seluler" value="{{ old('nomor_telepon_seluler', $siswa->nomor_telepon_seluler ?? '') }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomor_telepon_rumah" class="form-label">Nomor Telepon Rumah</label>
                <input type="text" class="form-control" id="nomor_telepon_rumah" name="nomor_telepon_rumah" value="{{ old('nomor_telepon_rumah', $siswa->nomor_telepon_rumah ?? '') }}" readonly>
            </div>
             <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $siswa->email ?? '') }}" readonly>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua / Wali Tab -->
    <div class="tab-pane fade" id="data-orang-tua" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-3">Data Ayah</h5>
                <div class="mb-3">
                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="pekerjaan_ayah_id" class="form-label">Pekerjaan Ayah</label>
                    <input type="text" class="form-control" id="pekerjaan_ayah_id" name="pekerjaan_ayah_id" value="{{ old('pekerjaan_ayah_id', $siswa->pekerjaan_ayah_id ?? '') }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <h5 class="mb-3">Data Ibu</h5>
                <div class="mb-3">
                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}" readonly>
                </div>
                 <div class="mb-3">
                    <label for="pekerjaan_ibu_id" class="form-label">Pekerjaan Ibu</label>
                    <input type="text" class="form-control" id="pekerjaan_ibu_id" name="pekerjaan_ibu_id" value="{{ old('pekerjaan_ibu_id', $siswa->pekerjaan_ibu_id ?? '') }}" readonly>
                </div>
            </div>
             <div class="col-12 mt-3">
                <h5 class="mb-3">Data Wali (Jika Ada)</h5>
                 <div class="row">
                     <div class="col-md-6 mb-3">
                         <label for="wali_id" class="form-label">Nama Wali</label>
                         <input type="text" class="form-control" id="wali_id" name="wali_id" value="{{ old('wali_id', $siswa->wali_id ?? '') }}" readonly>
                     </div>
                     <div class="col-md-6 mb-3">
                         <label for="pekerjaan_wali_id" class="form-label">Pekerjaan Wali</label>
                         <input type="text" class="form-control" id="pekerjaan_wali_id" name="pekerjaan_wali_id" value="{{ old('pekerjaan_wali_id', $siswa->pekerjaan_wali_id ?? '') }}" readonly>
                     </div>
                 </div>
            </div>
        </div>
    </div>

    <!-- Akademik Tab -->
    <div class="tab-pane fade" id="akademik" role="tabpanel">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="jenis_pendaftaran_id" class="form-label">Jenis Pendaftaran</label>
                <input type="text" class="form-control" id="jenis_pendaftaran_id" name="jenis_pendaftaran_id" value="{{ old('jenis_pendaftaran_id', $siswa->jenis_pendaftaran_id ?? '') }}" readonly>
            </div>
             <div class="col-md-6 mb-3">
                <label for="tanggal_masuk_sekolah" class="form-label">Tanggal Masuk Sekolah</label>
                <input type="date" class="form-control" id="tanggal_masuk_sekolah" name="tanggal_masuk_sekolah" value="{{ old('tanggal_masuk_sekolah', $siswa->tanggal_masuk_sekolah ?? '') }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="sekolah_asal" class="form-label">Sekolah Asal</label>
                <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" value="{{ old('sekolah_asal', $siswa->sekolah_asal ?? '') }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" id="kelas" name="kelas" value="{{ old('kelas', $siswa->rombel->nama_rombel ?? '') }}" readonly>
            </div>
             <div class="col-md-6 mb-3">
                <label for="semester_id" class="form-label">Semester</label>
                <input type="text" class="form-control" id="semester_id" name="semester_id" value="{{ old('semester_id', $siswa->semester_id ?? '') }}" readonly>
            </div>
        </div>
    </div>

    <!-- Kesehatan Tab -->
    <div class="tab-pane fade" id="kesehatan" role="tabpanel">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan', $siswa->tinggi_badan ?? '') }}" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan', $siswa->berat_badan ?? '') }}" readonly>
            </div>
        </div>
    </div>
</div>
