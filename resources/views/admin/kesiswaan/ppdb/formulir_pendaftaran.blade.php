@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">PPDB /</span> Calon Siswa
</h4>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">{{ isset($calonSiswa) ? 'Edit Calon Siswa' : 'Tambah Calon Siswa' }}</h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="submit" form="calonSiswaForm" class="btn btn-primary d-flex align-items-center">
                        <i class='bx bx-save me-1'></i> Simpan
                    </button>
                    <a href="{{ route('admin.kesiswaan.ppdb.formulir-ppdb.index') }}" class="btn btn-success d-flex align-items-center">
                        <i class='bx bx-plus me-1'></i> Baru
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form id="calonSiswaForm" method="POST" 
                      action="{{ isset($calonSiswa) 
                                  ? route('admin.kesiswaan.ppdb.formulir-ppdb.update', $calonSiswa->id) 
                                  : route('admin.kesiswaan.ppdb.formulir-ppdb.store') }}">
                    @csrf
                    @if(isset($calonSiswa))
                        @method('PUT')
                    @endif

                    <div class="row">

                        {{-- Kolom 1 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Tahun Pendaftaran PPDB</label>
                                <input type="hidden" name="tahun_id" value="{{ $tahunAktif->id ?? '' }}">
                                <input type="text" class="form-control" value="{{ $tahunAktif->tahun_pelajaran ?? '' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" 
                                       value="{{ old('nama_lengkap', $calonSiswa->nama_lengkap ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control"
                                       value="{{ old('nisn', $calonSiswa->nisn ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">NPUN</label>
                                <input type="text" name="npun" class="form-control"
                                       value="{{ old('npun', $calonSiswa->npun ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="d-flex gap-3 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="L"
                                            {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="P"
                                            {{ old('jenis_kelamin', $calonSiswa->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                       value="{{ old('tempat_lahir', $calonSiswa->tempat_lahir ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control"
                                       value="{{ old('tgl_lahir', $calonSiswa->tgl_lahir ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control"
                                       value="{{ old('nama_ayah', $calonSiswa->nama_ayah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control"
                                       value="{{ old('nama_ibu', $calonSiswa->nama_ibu ?? '') }}">
                            </div>
                        </div>

                        {{-- Kolom 2 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control"
                                       value="{{ old('alamat', $calonSiswa->alamat ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Desa</label>
                                <input type="text" name="desa" class="form-control"
                                       value="{{ old('desa', $calonSiswa->desa ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control"
                                       value="{{ old('kecamatan', $calonSiswa->kecamatan ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" name="kabupaten" class="form-control"
                                       value="{{ old('kabupaten', $calonSiswa->kabupaten ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control"
                                       value="{{ old('provinsi', $calonSiswa->provinsi ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kode Pos</label>
                                <input type="text" name="kode_pos" class="form-control"
                                       value="{{ old('kode_pos', $calonSiswa->kode_pos ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="text" name="kontak" class="form-control"
                                       value="{{ old('kontak', $calonSiswa->kontak ?? '') }}">
                            </div>
                        </div>

                        {{-- Kolom 3 --}}
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Asal Sekolah</label>
                                <input type="text" name="asal_sekolah" class="form-control"
                                       value="{{ old('asal_sekolah', $calonSiswa->asal_sekolah ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select name="kelas" class="form-select">
                                    <option value="">- Pilih Kelas -</option>
                                    @for($i=65;$i<=75;$i++)
                                        @php $huruf = chr($i); @endphp
                                        <option value="9 {{ $huruf }}" 
                                            {{ old('kelas', $calonSiswa->kelas ?? '') == "9 $huruf" ? 'selected' : '' }}>
                                            9 {{ $huruf }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jurusan Yang Diminati</label>
                                <select name="jurusan" class="form-select">
                                    <option>- pilih -</option>
                                    <option value="IPA" {{ old('jurusan', $calonSiswa->jurusan ?? '') == 'IPA' ? 'selected' : '' }}>IPA</option>
                                    <option value="IPS" {{ old('jurusan', $calonSiswa->jurusan ?? '') == 'IPS' ? 'selected' : '' }}>IPS</option>
                                    <option value="Bahasa" {{ old('jurusan', $calonSiswa->jurusan ?? '') == 'Bahasa' ? 'selected' : '' }}>Bahasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ukuran Pakaian</label>
                                <select name="ukuran_pakaian" class="form-select">
                                    <option>- pilih -</option>
                                    @foreach(['S','M','L','XL','XXL','XXXL','JB'] as $size)
                                        <option value="{{ $size }}" 
                                            {{ old('ukuran_pakaian', $calonSiswa->ukuran_pakaian ?? '') == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pembayaran</label>
                                <input type="number" name="pembayaran" class="form-control"
                                       value="{{ old('pembayaran', $calonSiswa->pembayaran ?? 0) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jalur Pendaftaran</label>
                                <select name="jalur_id" id="jalurPendaftaran" class="form-select">
                                    <option value="">- pilih -</option>
                                    @foreach($jalurs as $jalur)
                                        <option value="{{ $jalur->id }}" 
                                            {{ old('jalur_id', $calonSiswa->jalur_id ?? '') == $jalur->id ? 'selected' : '' }}>
                                            {{ $jalur->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Syarat - Syarat</label>
                                <div id="syaratContainer" class="border rounded p-3 bg-light">
                                    @if(isset($calonSiswa))
                                        @foreach($calonSiswa->syarat as $s)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="documents[{{ $s->id }}]" 
                                                       {{ $s->pivot->is_checked ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $s->syarat }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        Silahkan pilih jalur terlebih dahulu
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
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

    // data syarat yang sudah pernah dipilih (buat edit mode)
    let checkedSyarat = @json(isset($calonSiswa) ? $calonSiswa->syarat->pluck('id') : []);

    // function load syarat
    function loadSyarat(jalurId) {
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
                    const checked = checkedSyarat.includes(s.id) ? 'checked' : '';
                    syaratContainer.innerHTML += `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="syarat_${s.id}" 
                                   name="documents[${s.id}]" ${checked}>
                            <label class="form-check-label" for="syarat_${s.id}">${s.syarat}</label>
                        </div>
                    `;
                });
            });
    }

    // trigger saat ganti jalur
    jalurSelect.addEventListener("change", function() {
        loadSyarat(this.value);
    });

    // kalau edit mode -> langsung load syarat sesuai jalur yang tersimpan
    if(jalurSelect.value) {
        loadSyarat(jalurSelect.value);
    }
});
</script>
@endsection
