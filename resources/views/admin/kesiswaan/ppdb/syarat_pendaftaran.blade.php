@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Syarat Pendaftaran PPDB</h4>

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
            <h5 class="card-header">Syarat Pendaftaran</h5>

        </div>
    </div>
</div>
@endsection