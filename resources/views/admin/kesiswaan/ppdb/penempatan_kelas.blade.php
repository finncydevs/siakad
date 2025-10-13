@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Penempatan Kelas</h4>

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
            <h5 class="card-header">Penempatan Kelas Siswa</h5>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.kesiswaan.ppdb.penempatan-kelas.index') }}">
                            <label class="form-label">Filter Jurusan</label>
                            <select name="jurusan" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Semua Jurusan --</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                        {{ $jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <label for="pilih_kelas" class="form-label">Pilih Kelas Tujuan</label>
                        
                        <select id="pilih_kelas" class="form-select">
                            <option value="">- Pilih Kelas Tujuan -</option>
                            @foreach ( $kelas as $rombel )
                            <option value="{{ $rombel -> nama }} "> {{ $rombel -> nama }} </option>
                            {{-- Looping kelas tujuan --}}
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    {{-- Tabel siswa belum ditempatkan --}}
                    <div class="col-md-6">
                        <h6>Daftar Siswa Belum Ditempatkan</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                        <th>SEKOLAH ASAL</th>
                                        <th>
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($belumDitempatkan as $index => $formulir)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $formulir->nis ?? '-' }}</td>
                                            <td>{{ $formulir->nama_lengkap }}</td>
                                            <td>{{ $formulir->asal_sekolah ?? '-' }}</td>
                                            <td>
                                                <input type="checkbox" name="siswa_id[]" value="{{ $formulir->id }}">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Maaf, data tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>

                    {{-- Tabel siswa sudah ditempatkan --}}
                    <div class="col-md-6">
                        <h6>Daftar Siswa Sudah Ditempatkan</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NIS</th>
                                        <th>NAMA SISWA</th>
                                        <th>KELAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sudahDitempatkan as $index => $siswa) 
                                    <tr> 
                                        <td>{{ $index + 1 }}</td> 
                                        <td>{{ $siswa->nis ?? '-' }}</td> 
                                        <td>{{ $siswa->nama_lengkap }}</td> 
                                        <td>{{ $siswa->kelas_tujuan }}</td> 
                                    </tr> 
                                    @empty 
                                    <tr> 
                                        <td colspan="4" class="text-center text-muted">Tidak ada data</td> 
                                    </tr> 
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
    <button type="button" id="btnTempatkan" class="btn btn-primary" style="display:none;">
        Tempatkan Kelas
    </button>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    let pilihKelas = document.getElementById('pilih_kelas');
    let btnTempatkan = document.getElementById('btnTempatkan');

    // Saat ganti pilihan kelas
    pilihKelas.addEventListener('change', function() {
        if (this.value) {
            btnTempatkan.style.display = 'inline-block'; // munculkan
        } else {
            btnTempatkan.style.display = 'none'; // sembunyikan lagi
        }
    });

    // Check all
    document.getElementById('checkAll').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="siswa_id[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    // Tombol submit
    document.getElementById('btnTempatkan').addEventListener('click', function() {
        let kelasTujuan = document.getElementById('pilih_kelas').value;
        let siswaIds = Array.from(document.querySelectorAll('input[name="siswa_id[]"]:checked'))
            .map(cb => cb.value);

        if (!kelasTujuan) {
            alert("Pilih kelas tujuan dulu!");
            return;
        }

        if (siswaIds.length === 0) {
            alert("Checklist minimal 1 siswa!");
            return;
        }

        // Kirim ke backend via fetch/AJAX
        fetch("{{ route('admin.kesiswaan.ppdb.penempatan-kelas.update-kelas') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                kelas_tujuan: kelasTujuan,
                siswa_id: siswaIds
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Siswa berhasil ditempatkan!");
                location.reload();
            } else {
                alert("Gagal: " + data.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Terjadi error!");
        });
    });
</script>
@endsection
