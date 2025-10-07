@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Tahun Pendaftaran PPDB</h4>

<div class="row">
    <div class="col-md-12">

       <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-4">
          <h5 class="card-header">Tahun Pendaftaran</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun Pendaftaran</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                  @forelse ($tahunPelajaran as $index => $tahun)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $tahun->tahun_pelajaran }}</td>
                      <td>{{ $tahun->keterangan ?? '-' }}</td>
                      <td>
                          @if ($tahun->active)
                              <span class="badge bg-label-success me-1">Active</span>
                          @else
                              <span class="badge bg-label-secondary me-1">Inactive</span>
                          @endif
                      </td>
                      <td>
                          <form action="{{ route('admin.kesiswaan.ppdb.tahun-ppdb.toggleActive', $tahun->id) }}" method="POST">
                              @csrf
                                <button type="submit" 
                                  class="btn btn-icon btn-sm me-1 @if($tahun->active) text-success @else text-info @endif"
                                  data-bs-toggle="tooltip" data-bs-placement="top" 
                                  title="@if($tahun->active) Tahun Aktif @else Aktifkan Tahun @endif" 
                                  @if($tahun->active) disabled @endif
                                  >
                                      <i class='bx @if($tahun->active) bx-check-square @else bx-power-off @endif'></i>
                                </button>
                          </form>
                      
                          {{-- <a class="btn btn-icon btn-sm btn-outline-primary me-1" href="{{ route('admin.kesiswaan.ppdb.tahun-ppdb.edit', $tahun->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                              <i class="bx bx-edit-alt"></i>
                          </a> --}}
                          {{-- <form action="{{ route('admin.pegawai.destroy', $pegawai->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                  <i class="bx bx-trash"></i>
                              </button>
                          </form> --}}
                      </td>

                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center">Belum ada tahun pendaftaran</td>
                  </tr>
                  @endforelse
              </tbody>

            </table>
          </div>
        </div>
       <!-- Bootstrap Table with Header - Light -->
    </div>
</div>
@endsection
