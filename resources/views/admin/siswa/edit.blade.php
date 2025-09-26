    @extends('layouts.admin')

    @section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kesiswaan / Data Siswa /</span> Edit Data</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kesiswaan.siswa.update', $siswa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.siswa._form-tabs')
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Data Siswa</button>
                </div>
            </form>
        </div>
    </div>
    @endsection
    
