{{--
    File _form.blade.php yang sudah diperbarui.
    - Mengubah rasio pratinjau foto menjadi 3:4.
--}}
<div class="row">
    <!-- ======================================= -->
    <!-- KOLOM 1: FOTO & TTD                 -->
    <!-- ======================================= -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pas Foto</label>
                    {{-- PERUBAHAN DI SINI: Memperbaiki kesalahan pengetikan --}}
                    <img src="{{ isset($pegawai) && $pegawai->foto ? asset('storage/' . $pegawai->foto) : 'https://placehold.co/300x400?text=Foto+Pegawai' }}"
                         alt="Foto Pegawai"
                         class="img-thumbnail d-block mb-2"
                         id="foto-preview"
                         style="width:100%; height: auto; aspect-ratio: 3/4; object-fit: cover;">
                    <input type="file" class="form-control" name="foto" id="foto" onchange="previewImage('foto', 'foto-preview');">
                    <small class="form-text text-muted">Tipe: jpeg, png, jpg, gif. Ukuran Maks: 2MB</small>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan</label>
                    <img src="{{ isset($pegawai) && $pegawai->tanda_tangan ? asset('storage/' . $pegawai->tanda_tangan) : 'https://placehold.co/150x100?text=Tanda+Tangan' }}"
                         alt="Tanda Tangan"
                         class="img-thumbnail d-block mb-2"
                         id="ttd-preview"
                         style="width:100%; height: 100px; object-fit: contain; background-color: #f8f9fa;">
                    <input type="file" class="form-control" name="tanda_tangan" id="tanda_tangan" onchange="previewImage('tanda_tangan', 'ttd-preview');">
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================= -->
    <!-- KOLOM 2: DATA UTAMA                 -->
    <!-- ======================================= -->
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $pegawai->nama_lengkap ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gelar Depan</label>
            <input type="text" class="form-control" name="gelar_depan" value="{{ old('gelar_depan', $pegawai->gelar_depan ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Gelar Belakang</label>
            <input type="text" class="form-control" name="gelar_belakang" value="{{ old('gelar_belakang', $pegawai->gelar_belakang ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Kewarganegaraan</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kewarganegaraan" id="wni" value="WNI" {{ (old('kewarganegaraan', $pegawai->kewarganegaraan ?? 'WNI') == 'WNI') ? 'checked' : '' }}>
                    <label class="form-check-label" for="wni">WNI</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kewarganegaraan" id="wna" value="WNA" {{ (old('kewarganegaraan', $pegawai->kewarganegaraan ?? '') == 'WNA') ? 'checked' : '' }}>
                    <label class="form-check-label" for="wna">WNA</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">NIK/No. Passport</label>
            <input type="text" class="form-control" name="nik" value="{{ old('nik', $pegawai->nik ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NIY/NIGK</label>
            <input type="text" class="form-control" name="niy_nigk" value="{{ old('niy_nigk', $pegawai->niy_nigk ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NUPTK</label>
            <input type="text" class="form-control" name="nuptk" value="{{ old('nuptk', $pegawai->nuptk ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" class="form-control" name="nip" value="{{ old('nip', $pegawai->nip ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NPWP</label>
            <input type="text" class="form-control" name="npwp" value="{{ old('npwp', $pegawai->npwp ?? '') }}">
        </div>
    </div>

    <!-- ======================================= -->
    <!-- KOLOM 3: DATA PRIBADI             -->
    <!-- ======================================= -->
    <div class="col-md-3">
        <div class="row">
             <div class="col-md-6 mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $pegawai->tempat_lahir ?? '') }}">
            </div>
             <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $pegawai->tanggal_lahir ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
             <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki" value="Laki-laki" {{ (old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Laki-laki') ? 'checked' : '' }}>
                    <label class="form-check-label" for="laki">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ (old('jenis_kelamin', $pegawai->jenis_kelamin ?? '') == 'Perempuan') ? 'checked' : '' }}>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Agama</label>
            <select class="form-select" name="agama">
                <option value="" disabled selected>- Pilih Agama -</option>
                <option value="Islam" {{ (old('agama', $pegawai->agama ?? '') == 'Islam') ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ (old('agama', $pegawai->agama ?? '') == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                <option value="Katolik" {{ (old('agama', $pegawai->agama ?? '') == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                <option value="Hindu" {{ (old('agama', $pegawai->agama ?? '') == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                <option value="Budha" {{ (old('agama', $pegawai->agama ?? '') == 'Budha') ? 'selected' : '' }}>Budha</option>
                <option value="Konghucu" {{ (old('agama', $pegawai->agama ?? '') == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Ibu Kandung</label>
            <input type="text" class="form-control" name="nama_ibu_kandung" value="{{ old('nama_ibu_kandung', $pegawai->nama_ibu_kandung ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Status Pernikahan</label>
            <select class="form-select" name="status_pernikahan">
                <option value="" disabled selected>- Pilih Status -</option>
                <option value="Belum Menikah" {{ (old('status_pernikahan', $pegawai->status_pernikahan ?? '') == 'Belum Menikah') ? 'selected' : '' }}>Belum Menikah</option>
                <option value="Menikah" {{ (old('status_pernikahan', $pegawai->status_pernikahan ?? '') == 'Menikah') ? 'selected' : '' }}>Menikah</option>
                <option value="Cerai" {{ (old('status_pernikahan', $pegawai->status_pernikahan ?? '') == 'Cerai') ? 'selected' : '' }}>Cerai</option>
            </select>
        </div>
        <div class="row">
            <div class="col-md-7 mb-3">
                <label class="form-label">Nama Suami/Istri</label>
                <input type="text" class="form-control" name="nama_pasangan" value="{{ old('nama_pasangan', $pegawai->nama_pasangan ?? '') }}">
            </div>
             <div class="col-md-5 mb-3">
                <label class="form-label">Jumlah Anak</label>
                <input type="number" class="form-control" name="jumlah_anak" value="{{ old('jumlah_anak', $pegawai->jumlah_anak ?? '0') }}">
            </div>
        </div>
    </div>
    
    <!-- ======================================= -->
    <!-- KOLOM 4: ALAMAT & KONTAK            -->
    <!-- ======================================= -->
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">Alamat Lengkap</label>
            <textarea class="form-control" name="alamat" rows="3">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
        </div>
         <div class="mb-3">
            <label class="form-label">Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" value="{{ old('kecamatan', $pegawai->kecamatan ?? '') }}">
        </div>
         <div class="mb-3">
            <label class="form-label">Desa</label>
            <input type="text" class="form-control" name="desa" value="{{ old('desa', $pegawai->desa ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Kabupaten</label>
            <input type="text" class="form-control" name="kabupaten" value="{{ old('kabupaten', $pegawai->kabupaten ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Provinsi</label>
            <input type="text" class="form-control" name="provinsi" value="{{ old('provinsi', $pegawai->provinsi ?? '') }}">
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kode Pos</label>
                <input type="text" class="form-control" name="kode_pos" value="{{ old('kode_pos', $pegawai->kode_pos ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kontak</label>
                <input type="text" class="form-control" name="kontak" value="{{ old('kontak', $pegawai->kontak ?? '') }}">
            </div>
        </div>
    </div>
</div>

