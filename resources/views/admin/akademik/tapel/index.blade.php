@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">
            <span class="text-muted fw-light">Akademik /</span> Tahun Pelajaran
        </h4>
        <a href="{{ route('admin.akademik.tapel.sinkron') }}" class="btn btn-success btn-sm">
            <i class="bx bx-refresh"></i> Sinkron Tapel
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Tahun Pelajaran</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Tapel</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tapel as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->kode_tapel }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>
                                @if(!$item->is_active)
                                    <form action="{{ route('admin.akademik.tapel.aktif', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Jadikan Aktif
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data Tapel</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
