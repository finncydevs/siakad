@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Jadwal Pelajaran /</span> Atur Jadwal untuk Kelas {{ $rombel->nama }}
</h4>

@if (session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Jadwal Pelajaran Kelas: {{ $rombel->nama }}</h5>
            <a href="{{ route('admin.jadwal-pelajaran.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar Kelas
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jadwal-pelajaran.store', $rombel->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Jam Ke</th>
                            <th>Waktu</th>
                            @foreach ($days as $day)
                                <th>{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jamPelajaran as $jam)
                            <tr>
                                <td><strong>{{ $jam }}</strong></td>
                                <td>
                                    @php
                                        // Logika untuk mencari waktu yang sudah ada di baris ini
                                        $waktu_mulai = '';
                                        $waktu_selesai = '';
                                        foreach ($days as $day) {
                                            if (isset($existingJadwal[$day.'_'.$jam])) {
                                                $waktu_mulai = $existingJadwal[$day.'_'.$jam]->waktu_mulai;
                                                $waktu_selesai = $existingJadwal[$day.'_'.$jam]->waktu_selesai;
                                                break; // Keluar dari loop jika sudah ditemukan
                                            }
                                        }
                                    @endphp
                                    <div class="d-flex">
                                        <input type="time" name="waktu[{{ $jam }}][mulai]" class="form-control form-control-sm" value="{{ $waktu_mulai }}">
                                        <input type="time" name="waktu[{{ $jam }}][selesai]" class="form-control form-control-sm ms-1" value="{{ $waktu_selesai }}">
                                    </div>
                                </td>
                                @foreach ($days as $day)
                                    @php
                                        $jadwal = $existingJadwal[$day.'_'.$jam] ?? null;
                                    @endphp
                                    <td>
                                        <select name="jadwal[{{ $day }}][{{ $jam }}][pembelajaran_id]" class="form-select form-select-sm">
                                            <option value="">-- Kosong --</option>
                                            @if(!empty($availablePelajaran))
                                                @foreach ($availablePelajaran as $p)
                                                    <option value="{{ $p['mata_pelajaran_id'] }}|{{ $p['nama_mata_pelajaran'] }}|{{ $p['ptk_id_str'] }}"
                                                        {{ ($jadwal && $jadwal->pembelajaran_id == $p['mata_pelajaran_id']) ? 'selected' : '' }}>
                                                        {{ Str::limit($p['nama_mata_pelajaran'], 20) }} - {{ Str::limit($p['ptk_id_str'], 15) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> Simpan Jadwal Pelajaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

