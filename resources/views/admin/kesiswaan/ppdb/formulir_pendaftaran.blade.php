@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">PPDB /</span> Formulir Pendaftaran
</h4>

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
                <h5 class="mb-0">Formulir Pendaftaran</h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="submit" form="formulirId" class="btn btn-primary d-flex align-items-center">
                        <i class='bx bx-save me-1'></i> Simpan
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center" id="btnResetForm">
                        <i class='bx bx-plus me-1'></i> Baru
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="formulirId">
                    <div class="row">

                        {{-- Kolom 1 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pendaftaran PPDB</label>
                                <input type="text" id="tahunPendaftaran" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" id="namaLengkap" class="form-control" placeholder="nama lengkap calon siswa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="number" id="nisn" class="form-control" placeholder="NISN calon siswa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPUN</label>
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
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" id="tempatLahir" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" id="tglLahir" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" id="namaAyah" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" id="namaIbu" class="form-control">
                            </div>
                        </div>

                        {{-- Kolom 2 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" id="alamat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Desa</label>
                                <input type="text" id="desa" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" id="kecamatan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" id="kabupaten" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" id="provinsi" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="number" id="kodePos" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="number" id="kontak" class="form-control">
                            </div>
                        </div>

                        {{-- Kolom 3 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" id="asalSekolah" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select id="kelas" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan Yang Diminati</label>
                                <select id="jurusan" class="form-select">
                                    <option>- pilih -</option>
                                    <option value="IPA">1 | IPA</option>
                                    <option value="IPS">2 | IPS</option>
                                    <option value="Bahasa">3 | Bahasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ukuran Pakaian</label>
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
                                <label class="form-label">Pembayaran</label>
                                <input type="number" id="pembayaran" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jalur Pendaftaran</label>
                                <select id="jalurPendaftaran" class="form-select"></select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Syarat - Syarat</label>
                                <div id="syaratContainer" class="border rounded p-3 bg-light">
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

{{-- Script --}}
<script>
const kelasSelect = document.getElementById("kelas");
const jalurSelect = document.getElementById("jalurPendaftaran");
const syaratContainer = document.getElementById("syaratContainer");

// Render kelas A-K
function renderSelectKelas() {
    kelasSelect.innerHTML = '<option value="" selected>- Pilih Kelas -</option>';
    for (let i = 65; i <= 75; i++) {
        const huruf = String.fromCharCode(i);
        kelasSelect.appendChild(new Option(`9 ${huruf}`, `9 ${huruf}`));
    }
}
document.addEventListener("DOMContentLoaded", renderSelectKelas);

// Fetch syarat saat pilih jalur
jalurSelect.addEventListener('change', function() {
    const jalurId = this.value;
    if(!jalurId) {
        syaratContainer.innerHTML = 'Silahkan pilih jalur terlebih dahulu';
        return;
    }

    fetch(`/admin/kesiswaan/ppdb/syarat-ppdb?jalur_id=${jalurId}`)
    .then(res => res.json())
    .then(data => {
        syaratContainer.innerHTML = '';
        if(data.length === 0) {
            syaratContainer.innerHTML = 'Tidak ada syarat aktif untuk jalur ini';
            return;
        }
        data.forEach(s => {
            syaratContainer.innerHTML += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="syarat_${s.id}" name="documents[${s.id}]">
                    <label class="form-check-label" for="syarat_${s.id}">${s.syarat}</label>
                </div>`;
        });
    });
});

// Reset form untuk tambah baru
document.getElementById('btnResetForm').addEventListener('click', function() {
    document.getElementById('formulirId').reset();
    syaratContainer.innerHTML = 'Silahkan pilih jalur terlebih dahulu';
});
</script>
@endsection
