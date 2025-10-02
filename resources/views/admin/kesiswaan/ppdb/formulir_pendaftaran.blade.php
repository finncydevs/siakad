@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">PPDB /</span> Calon Siswa
</h4>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">{{ isset($formulir) ? 'Edit Calon Siswa' : 'Tambah Calon Siswa' }}</h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="submit" form="calonSiswaForm" class="btn btn-primary d-flex align-items-center">
                        <i class='bx bx-save me-1'></i> Simpan
                    </button>
                    <a href="{{ route('admin.kesiswaan.ppdb.formulir-ppdb.index') }}" 
                       class="btn btn-success d-flex align-items-center">
                        <i class='bx bx-plus me-1'></i> Baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form id="calonSiswaForm" method="POST" 
                      action="{{ isset($formulir) 
                                  ? route('admin.kesiswaan.ppdb.formulir-ppdb.update', $formulir->id) 
                                  : route('admin.kesiswaan.ppdb.formulir-ppdb.store') }}">
                    @csrf
                    @if(isset($formulir))
                        @method('PUT')
                    @endif

                    <div class="row">

                        {{-- 🔹 Kolom 1 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pendaftaran PPDB</label>
                                <input type="hidden" name="tahun_id" value="{{ $tahunAktif->id ?? '' }}">
                                <input type="text" class="form-control" 
                                       value="{{ $tahunAktif->tahun_pelajaran ?? '' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" 
                                       value="{{ old('nama_lengkap', $formulir->nama_lengkap ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control"
                                       value="{{ old('nisn', $formulir->nisn ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPUN</label>
                                <input type="text" name="npun" class="form-control"
                                       value="{{ old('npun', $formulir->npun ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="d-flex gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="L"
                                            {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="P"
                                            {{ old('jenis_kelamin', $formulir->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                       value="{{ old('tempat_lahir', $formulir->tempat_lahir ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control"
                                       value="{{ old('tgl_lahir', $formulir->tgl_lahir ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control"
                                       value="{{ old('nama_ayah', $formulir->nama_ayah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control"
                                       value="{{ old('nama_ibu', $formulir->nama_ibu ?? '') }}">
                            </div>
                        </div>

                        {{-- 🔹 Kolom 2 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control"
                                       value="{{ old('alamat', $formulir->alamat ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Desa</label>
                                <input type="text" name="desa" class="form-control"
                                       value="{{ old('desa', $formulir->desa ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control"
                                       value="{{ old('kecamatan', $formulir->kecamatan ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" name="kabupaten" class="form-control"
                                       value="{{ old('kabupaten', $formulir->kabupaten ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control"
                                       value="{{ old('provinsi', $formulir->provinsi ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="kode_pos" class="form-control"
                                       value="{{ old('kode_pos', $formulir->kode_pos ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="text" name="kontak" class="form-control"
                                       value="{{ old('kontak', $formulir->kontak ?? '') }}">
                            </div>
                        </div>

                        {{-- 🔹 Kolom 3 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control"
                                       value="{{ old('asal_sekolah', $formulir->asal_sekolah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select">
                                    <option value="">- Pilih Kelas -</option>
                                    @for($i=65; $i<=75; $i++)
                                        @php $huruf = chr($i); @endphp
                                        <option value="9 {{ $huruf }}" 
                                            {{ old('kelas', $formulir->kelas ?? '') == "9 $huruf" ? 'selected' : '' }}>
                                            9 {{ $huruf }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan Yang Diminati</label>
                                <select name="jurusan" class="form-select">
                                    <option>- pilih -</option>
                                    @foreach(['IPA','IPS','Bahasa'] as $jurusan)
                                        <option value="{{ $jurusan }}" 
                                            {{ old('jurusan', $formulir->jurusan ?? '') == $jurusan ? 'selected' : '' }}>
                                            {{ $jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ukuran Pakaian</label>
                                <select name="ukuran_pakaian" class="form-select">
                                    <option>- pilih -</option>
                                    @foreach(['S','M','L','XL','XXL','XXXL','JB'] as $size)
                                        <option value="{{ $size }}" 
                                            {{ old('ukuran_pakaian', $formulir->ukuran_pakaian ?? '') == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pembayaran</label>
                                <input type="number" name="pembayaran" class="form-control"
                                       value="{{ old('pembayaran', $formulir->pembayaran ?? 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jalur Pendaftaran</label>
                                <select name="jalur_id" id="jalurPendaftaran" class="form-select">
                                    <option value="">- pilih -</option>
                                    @foreach($jalurs as $jalur)
                                        <option value="{{ $jalur->id }}" 
                                            {{ old('jalur_id', $formulir->jalur_id ?? '') == $jalur->id ? 'selected' : '' }}>
                                            {{ $jalur->jalur }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Syarat - Syarat</label>
                                <div id="syaratContainer" class="border rounded p-3 bg-light">
                                    Silahkan pilih jalur terlebih dahulu
                                </div>
                            </div>

                        </div>

                    </div> {{-- end row --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const jalurSelect = document.getElementById("jalurPendaftaran");
    const syaratContainer = document.getElementById("syaratContainer");

    // Kalau edit → ada syarat yang sudah tercentang
    let checkedSyarat = @json(isset($formulir) ? $formulir->syarat->pluck('id') : []);

    function loadSyarat(jalurId) {
        if(!jalurId) {
            syaratContainer.innerHTML = 'Silahkan pilih jalur terlebih dahulu';
            return;
        }

        fetch("{{ url('admin/kesiswaan/ppdb/get-syarat') }}/" + jalurId)
            .then(res => res.json())
            .then(data => {
                syaratContainer.innerHTML = '';

                if (data.length === 0) {
                    syaratContainer.innerHTML = 'Tidak ada syarat aktif untuk jalur ini';
                    return;
                }

                data.forEach(s => {
                    const checked = checkedSyarat.includes(s.id) ? 'checked' : '';
                    syaratContainer.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="syarat_${s.id}" 
                                   name="documents[${s.id}]" ${checked}>
                            <label class="form-check-label" for="syarat_${s.id}">${s.syarat}</label>
                        </div>
                    `;
                });
            })
            .catch(err => {
                console.error("Error ambil syarat:", err);
                syaratContainer.innerHTML = 'Gagal memuat syarat';
            });
    }

    // Event saat ganti jalur
    jalurSelect.addEventListener("change", function() {
        loadSyarat(this.value);
    });

    // Kalau edit mode langsung load syarat sesuai jalur tersimpan
    if(jalurSelect.value) {
        loadSyarat(jalurSelect.value);
    }
});
</script>
@endsection
