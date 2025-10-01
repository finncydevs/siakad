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
            {{-- Contoh 1 data dummy --}}
            <tr>
              <td>1</td>
              <td>
                <strong class="text-primary">137-250930.001</strong><br>
                <small class="text-muted">Zonasi / IPA</small>
              </td>
              <td>
                <strong>Ahmad Fauzi (L)</strong><br>
                <small class="text-muted">Ttl: Padang, 12 Januari 2010</small><br>
                <small class="text-muted">Telp: 081234567890</small><br>
                <small class="text-muted">Asal: SMPN 1 Padang</small>
              </td>
              <td>30 September 2025</td>
              <td>
                <ul class="mb-0 ps-3 text-danger">
                  <li>&times; Fotokopi KK</li>
                  <li>&times; Ijazah</li>
                </ul>
              </td>
              <td class="text-center">
                <span class="badge bg-warning text-dark">Syarat Belum Lengkap</span>
              </td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-2">
                  <a href="{{ url('admin/kesiswaan/ppdb/formulir?id=137-250930.001') }}" 
                     class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                    <i class="bx bx-edit"></i>
                  </a>
                  <button type="button" class="btn btn-sm btn-icon btn-outline-danger" title="Hapus">
                    <i class="bx bx-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
