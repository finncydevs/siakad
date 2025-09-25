@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Tahun Pendaftaran PPDB</h4>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">

       <!-- Bootstrap Table with Header - Light -->
        <div class="card mb-4">
          <h5 class="card-header">Tahun Pendaftaran</h5>
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tahun Pendaftaran</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                  @foreach ($tahunPelajaran as $index => $tahun)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $tahun->tahun_pelajaran }}</td>
                      <td>
                          @if ($tahun->is_active)
                              <span class="badge bg-label-success me-1">Active</span>
                          @else
                              <span class="badge bg-label-secondary me-1">Inactive</span>
                          @endif
                      </td>
                      <td>
                          <form action="{{ route('admin.ppdb.tahun-ppdb.toggleActive', $tahun->id) }}" method="POST" style="display:inline;">
                              @csrf
                              @if (! $tahun->is_active)
                                  <button type="submit" class="badge bg-label-primary border-0">
                                      <i class='bx bx-check-circle'></i>
                                  </button>
                              @else
                                  <button type="submit" class="badge bg-label-success border-0">
                                      <i class='bx bx-check-circle'></i>
                                  </button>
                              @endif
                          </form>
                      
                          <a href="{{ route('admin.ppdb.tahun-ppdb.edit', $tahun->id) }}" class="badge bg-label-primary me-1">
                              <i class='bx bx-edit'></i>
                          </a>
                      </td>

                  </tr>
                  @endforeach
              </tbody>

            </table>
          </div>
        </div>
       <!-- Bootstrap Table with Header - Light -->
    </div>
</div>
@endsection
