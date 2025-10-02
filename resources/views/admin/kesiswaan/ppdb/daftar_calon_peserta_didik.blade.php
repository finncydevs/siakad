@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">PPDB /</span> Calon Peserta Didik
</h4>

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Daftar Calon Peserta Didik</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Nomor Resi</th>
              <th>Informasi Pendaftar</th>
              <th>Tanggal Daftar</th>
              <th>Syarat-syarat</th>
              <th>Keterangan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($formulirs as $i => $calon)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>
                  <strong class="text-primary">{{ $calon->nomor_resi }}</strong><br>
                  <small class="text-muted">{{ $calon->jalurPendaftaran->jalur ?? '-' }}</small>
                </td>
                <td>
                  <strong>{{ $calon->nama_lengkap }} ({{ $calon->jenis_kelamin }})</strong><br>
                  <small class="text-muted">
                    Ttl: {{ $calon->tempat_lahir }}, {{ \Carbon\Carbon::parse($calon->tgl_lahir)->translatedFormat('d F Y') }}
                  </small><br>
                  <small class="text-muted">Telp: {{ $calon->kontak }}</small><br>
                  <small class="text-muted">Asal: {{ $calon->asal_sekolah }}</small>
                </td>
                <td>{{ $calon->created_at->translatedFormat('d F Y') }}</td>
                <td>
                  @php
                      $totalSyarat = $calon->jalurPendaftaran
                          ? $calon->jalurPendaftaran->syaratPendaftaran()->count()
                          : 0;

                      $syaratTerpenuhi = $calon->syarat->where('pivot.is_checked', true)->count();
                  @endphp

                  <ul class="mb-0 ps-3 list-unstyled">
                      @foreach($calon->syarat as $syarat)
                          <li class="d-flex align-items-center {{ $syarat->pivot->is_checked ? 'text-success' : 'text-danger' }}">
                              <i class="bx {{ $syarat->pivot->is_checked ? 'bx-check' : 'bx-x' }} me-2"></i>
                              {{ $syarat->syarat }}
                          </li>
                      @endforeach
                  </ul>
                </td>
                <td class="text-center">
                  @if($totalSyarat > 0 && $syaratTerpenuhi == $totalSyarat)
                      <span class="badge bg-success">Syarat Lengkap</span>
                  @else
                      <span class="badge bg-warning text-dark">Syarat Belum Lengkap</span>
                  @endif
                </td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('admin.kesiswaan.ppdb.formulir-ppdb.edit', $calon->id) }}" 
                       class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                      <i class="bx bx-edit"></i>
                    </a>
                    <form action="{{-- {{ route('admin.kesiswaan.ppdb.formulir.destroy', $calon->id) }} --}}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                        <i class="bx bx-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted">Belum ada data pendaftar</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
