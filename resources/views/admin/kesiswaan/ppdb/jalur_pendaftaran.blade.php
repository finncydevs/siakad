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
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="">Jalur Pendaftaran</h5>
            <!-- Button trigger modal -->
            <button
              type="button"
              class="btn btn-primary d-flex align-items-center"
              data-bs-toggle="modal"
              data-bs-target="#modalCenter">
                <i class='bx bx-plus me-1'></i> Tambah Jalur
            </button>
          </div>
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
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  {{-- @foreach ($tahunPpdb as $index => $tahun)
                  <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $tahun->tahun }}</td>
                      <td>
                          @if ($tahun->active)
                              <span class="badge bg-label-success me-1">Active</span>
                          @else
                              <span class="badge bg-label-secondary me-1">Inactive</span>
                          @endif
                      </td>
                      <td>
                          <form action="{{ route('admin.ppdb.tahun-ppdb.toggleActive', $tahun->id) }}" method="POST" style="display:inline;">
                              @csrf
                              @if (! $tahun->active)
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
                  @endforeach --}}
              </tbody>

            </table>
          </div>
        </div>
       <!-- Bootstrap Table with Header - Light -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Modal title</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col mb-6">
            <label for="nameWithTitle" class="form-label">Name</label>
            <input
              type="text"
              id="nameWithTitle"
              class="form-control"
              placeholder="Enter Name" />
          </div>
        </div>
        <div class="row g-6">
          <div class="col mb-0">
            <label for="emailWithTitle" class="form-label">Email</label>
            <input
              type="email"
              id="emailWithTitle"
              class="form-control"
              placeholder="xxxx@xxx.xx" />
          </div>
          <div class="col mb-0">
            <label for="dobWithTitle" class="form-label">DOB</label>
            <input type="date" id="dobWithTitle" class="form-control" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
          Close
        </button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection
