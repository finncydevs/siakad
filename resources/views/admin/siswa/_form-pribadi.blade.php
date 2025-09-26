<div class="row">
    <!-- Kolom 1: Foto & Nomor Induk -->
    <div class="col-md-3">
        <div class="mb-3">
            <label class="form-label">Foto 3x4</label>
            <img src="{{ isset($siswa) && $siswa->foto ? asset('storage/' . $siswa->foto) : 'https://placehold.co/300x400?text=Foto+Siswa' }}" 
                 alt="Foto Siswa" 
                 class="img-thumbnail d-block mb-2" 
                 id="foto-preview"
                 style="width:100%; height: auto; aspect-ratio: 3/4; object-fit: cover;">
            <input type="file" class="form-control" name="foto" id="foto" onchange="previewImage('foto', 'foto-preview');">
        </div>
        <div class="mb-3">
            <label class="form-label">NIS</label>
            <input type="text" class="form-control" name="nis" value="{{ old('nis', $siswa->nis ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NISN</label>
            <input type="text" class="form-control" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">NIK</label>
            <input type="text" class="form-control" name="nik" value="{{ old('nik', $siswa->nik ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Akte Kelahiran</label>
            <input type="text" class="form-control" name="no_akta_lahir" value="{{ old('no_akta_lahir', $siswa->no_akta_lahir ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Seri PIP</label>
            <input type="text" class="form-control" name="no_seri_pip" value="{{ old('no_seri_pip', $siswa->no_seri_pip ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">PKH/KKS</label>
            <input type="text" class="form-control" name="pkh_kks" value="{{ old('pkh_kks', $siswa->pkh_kks ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">KPS</label>
            <input type="text" class="form-control" name="kps" value="{{ old('kps', $siswa->kps ?? '') }}">
        </div>
    </div>

    <!-- Kolom 2: Data Diri -->
    <div class="col-md-5">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Panggilan</label>
            <input type="text" class="form-control" name="nama_panggilan" value="{{ old('nama_panggilan', $siswa->nama_panggilan ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Laki-laki') ? 'checked' : '' }}>
                    <label class="form-check-label" for="laki-laki">Laki-laki</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ (old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan') ? 'checked' : '' }}>
                    <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ?? '') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Agama</label>
            <select class="form-select" name="agama">
                <option value="" disabled selected>- Pilih Agama -</option>
                <option value="Islam" {{ (old('agama', $siswa->agama ?? '') == 'Islam') ? 'selected' : '' }}>Islam</option>
                <option value="Kristen" {{ (old('agama', $siswa->agama ?? '') == 'Kristen') ? 'selected' : '' }}>Kristen</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kewarganegaraan</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kewarganegaraan" id="wni" value="WNI" {{ (old('kewarganegaraan', $siswa->kewarganegaraan ?? 'WNI') == 'WNI') ? 'checked' : '' }}>
                    <label class="form-check-label" for="wni">WNI</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="kewarganegaraan" id="wna" value="WNA" {{ (old('kewarganegaraan', $siswa->kewarganegaraan ?? '') == 'WNA') ? 'checked' : '' }}>
                    <label class="form-check-label" for="wna">WNA</label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Golongan Darah</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="golongan_darah" id="gol-a" value="A" {{ (old('golongan_darah', $siswa->golongan_darah ?? '') == 'A') ? 'checked' : '' }}>
                    <label class="form-check-label" for="gol-a">A</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="golongan_darah" id="gol-b" value="B" {{ (old('golongan_darah', $siswa->golongan_darah ?? '') == 'B') ? 'checked' : '' }}>
                    <label class="form-check-label" for="gol-b">B</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="golongan_darah" id="gol-ab" value="AB" {{ (old('golongan_darah', $siswa->golongan_darah ?? '') == 'AB') ? 'checked' : '' }}>
                    <label class="form-check-label" for="gol-ab">AB</label>
                </div>
                 <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="golongan_darah" id="gol-o" value="O" {{ (old('golongan_darah', $siswa->golongan_darah ?? '') == 'O') ? 'checked' : '' }}>
                    <label class="form-check-label" for="gol-o">O</label>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom 3: Data Keluarga -->
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label">Bahasa Sehari-hari</label>
            <input type="text" class="form-control" name="bahasa_sehari_hari" value="{{ old('bahasa_sehari_hari', $siswa->bahasa_sehari_hari ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Anak Ke</label>
            <input type="number" class="form-control" name="anak_ke" value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Saudara Kandung</label>
            <input type="number" class="form-control" name="jumlah_saudara_kandung" value="{{ old('jumlah_saudara_kandung', $siswa->jumlah_saudara_kandung ?? '0') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Saudara Tiri</label>
            <input type="number" class="form-control" name="jumlah_saudara_tiri" value="{{ old('jumlah_saudara_tiri', $siswa->jumlah_saudara_tiri ?? '0') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Saudara Angkat</label>
            <input type="number" class="form-control" name="jumlah_saudara_angkat" value="{{ old('jumlah_saudara_angkat', $siswa->jumlah_saudara_angkat ?? '0') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Status dalam Keluarga</label>
            <select class="form-select" name="status_dalam_keluarga">
                <option value="Anak Kandung" {{ (old('status_dalam_keluarga', $siswa->status_dalam_keluarga ?? '') == 'Anak Kandung') ? 'selected' : '' }}>Anak Kandung</option>
                <option value="Anak Angkat" {{ (old('status_dalam_keluarga', $siswa->status_dalam_keluarga ?? '') == 'Anak Angkat') ? 'selected' : '' }}>Anak Angkat</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori Anak</label>
            <div>
                 <div class="form-check">
                    <input class="form-check-input" type="radio" name="kategori_anak" id="kategori-normal" value="Tanpa Kategori" {{ (old('kategori_anak', $siswa->kategori_anak ?? 'Tanpa Kategori') == 'Tanpa Kategori') ? 'checked' : '' }}>
                    <label class="form-check-label" for="kategori-normal">Tanpa Kategori</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="kategori_anak" id="kategori-yatim" value="Yatim" {{ (old('kategori_anak', $siswa->kategori_anak ?? '') == 'Yatim') ? 'checked' : '' }}>
                    <label class="form-check-label" for="kategori-yatim">Yatim</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="kategori_anak" id="kategori-piatu" value="Piatu" {{ (old('kategori_anak', $siswa->kategori_anak ?? '') == 'Piatu') ? 'checked' : '' }}>
                    <label class="form-check-label" for="kategori-piatu">Piatu</label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="radio" name="kategori_anak" id="kategori-yatimpiatu" value="Yatim Piatu" {{ (old('kategori_anak', $siswa->kategori_anak ?? '') == 'Yatim Piatu') ? 'checked' : '' }}>
                    <label class="form-check-label" for="kategori-yatimpiatu">Yatim Piatu</label>
                </div>
            </div>
        </div>
    </div>
</div>
