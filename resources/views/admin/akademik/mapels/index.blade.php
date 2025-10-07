@extends('layouts.admin') {{-- Layout utama Sneat Anda --}}

@section('title', 'Data Mata Pelajaran')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Akademik</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Mata Pelajaran</li>
            </ol>
        </nav>
    </div>

    <h4 class="fw-bold mb-4">
        <span class="text-muted fw-light">Akademik /</span> Daftar Mata Pelajaran
    </h4>

    <div class="card">
        <div class="card-header text-white"> 
            <h5 class="mb-0">Daftar Mata Pelajaran (Mapel)</h5>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                {{-- DITAMBAHKAN class table-hover DI SINI --}}
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Kode Mapel</th>
                            <th>Nama Mata Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mapels as $key => $mapel)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><strong>{{ $mapel['kode'] }}</strong></td>
                                <td>{{ $mapel['nama_mapel'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data Mata Pelajaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection