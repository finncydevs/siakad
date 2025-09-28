@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Formulir Pendaftaran</h4>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Formulir</h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="submit" form="formulirId" class="btn btn-primary d-flex align-items-center">
                        <i class='bx bx-save me-1'></i> Simpan
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center">
                        <i class='bx bx-plus me-1'></i> Baru
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="" id="formulirId">
                    <div class="row g-3">

                        <!-- Kolom 1 -->
                        <div class="col-lg-4 col-12">
                            <div class="mb-3">
                                <label for="tahunPendaftaran" class="form-label">Tahun Pendaftaran PPDB</label>
                                <input type="text" id="tahunPendaftaran" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" id="namaLengkap" class="form-control" placeholder="Nama lengkap calon siswa">
                            </div>
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="number" id="nisn" class="form-control" placeholder="NISN calon siswa">
                            </div>
                            <div class="mb-3">
                                <label for="npun" class="form-label">NPUN</label>
                                <input type="number" id="npun" class="form-control" placeholder="NPUN calon siswa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="d-flex gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenisKelamin" value="L" id="jkL">
                                        <label class="form-check-label" for="jkL">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenisKelamin" value="P" id="jkP">
                                        <label class="form-check-label" for="jkP">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tempatLahir" class="form-label">Tempat Lahir</label>
                                <input type="text" id="tempatLahir" class="form-control" placeholder="Tempat lahir calon siswa">
                            </div>
                            <div class="mb-3">
                                <label for="tglLahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tglLahir" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="namaAyah" class="form-label">Nama Ayah</label>
                                <input type="text" id="namaAyah" class="form-control" placeholder="Nama lengkap ayah">
                            </div>
                            <div class="mb-3">
                                <label for="namaIbu" class="form-label">Nama Ibu</label>
                                <input type="text" id="namaIbu" class="form-control" placeholder="Nama lengkap ibu">
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="col-lg-4 col-12">
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" id="alamat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="desa" class="form-label">Desa</label>
                                <input type="text" id="desa" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" id="kecamatan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <input type="text" id="kabupaten" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" id="provinsi" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kodePos" class="form-label">Kode Pos</label>
                                <input type="number" id="kodePos" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kontak" class="form-label">Kontak</label>
                                <input type="number" id="kontak" class="form-control">
                            </div>
                        </div>

                        <!-- Kolom 3 -->
                        <div class="col-lg-4 col-12">
                            <div class="mb-3">
                                <label for="asalSekolah" class="form-label">Asal Sekolah</label>
                                <input type="text" id="asalSekolah" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select id="kelas" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label for="jurusan" class="form-label">Jurusan Yang Diminati</label>
                                <select id="jurusan" class="form-select">
                                    <option>- pilih -</option>
                                    <option value="IPA">1 | IPA</option>
                                    <option value="IPS">2 | IPS</option>
                                    <option value="Bahasa">3 | Bahasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ukuranPakaian" class="form-label">Ukuran Pakaian</label>
                                <select id="ukuranPakaian" class="form-select">
                                    <option>- pilih -</option>
                                    <option>S (Small)</option>
                                    <option>M (Medium)</option>
                                    <option>L (Large)</option>
                                    <option>XL (Extra Large)</option>
                                    <option>XXL (2x Extra Large)</option>
                                    <option>XXXL (3x Extra Large)</option>
                                    <option>JB (Jumbo)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pembayaran" class="form-label">Pembayaran</label>
                                <input type="number" id="pembayaran" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="jalurPendaftaran" class="form-label">Jalur Pendaftaran</label>
                                <select id="jalurPendaftaran" class="form-select">
                                    <option></option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Syarat - Syarat</label>
                                <div id="syaratContainer" class="alert alert-info mt-2">
                                    Silahkan pilih jalur terlebih dahulu
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
  const kelasSelect = document.getElementById("kelas");

  // Render kelas A-K
  function renderSelectKelas() {
    kelasSelect.innerHTML = '<option value="" selected>- Pilih Kelas -</option>';
    for (let i = 65; i <= 75; i++) {
      const huruf = String.fromCharCode(i);
      kelasSelect.appendChild(new Option(`9 ${huruf}`, `9 ${huruf}`));
    }
  }

  // Panggil saat DOM siap
  document.addEventListener("DOMContentLoaded", renderSelectKelas);
</script>

@endsection
