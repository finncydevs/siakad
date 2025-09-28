@extends('layouts.admin')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">PPDB /</span> Formulir Pendaftaran</h4>

{{-- Pesan Sukses --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center">
                <h5 class="mb-0">Formulir</h5>
                <div class="ms-auto d-flex gap-2">
                    <button type="submit" form="formulirId" class="btn btn-primary d-flex align-items-center">
                        <i class='bx bx-save me-1'></i> Simpan
                    </button>
                    <button type="button" class="btn btn-success d-flex align-items-center" id="btnResetForm">
                        <i class='bx bx-plus me-1'></i> Baru
                    </button>
                </div>
            </div>
            
            
        </div>
    </div>
</div>

<script>
const kelasSelect = document.getElementById("kelas");
const jalurSelect = document.getElementById("jalurPendaftaran");
const syaratContainer = document.getElementById("syaratContainer");

// Render kelas A-K
function renderSelectKelas() {
    kelasSelect.innerHTML = '<option value="" selected>- Pilih Kelas -</option>';
    for (let i = 65; i <= 75; i++) {
        const huruf = String.fromCharCode(i);
        kelasSelect.appendChild(new Option(`9 ${huruf}`, `9 ${huruf}`));
    }
}
document.addEventListener("DOMContentLoaded", renderSelectKelas);

// Fetch syarat saat pilih jalur
jalurSelect.addEventListener('change', function() {
    const jalurId = this.value;
    if(!jalurId) {
        syaratContainer.innerHTML = 'Silahkan pilih jalur terlebih dahulu';
        return;
    }

    fetch(`/admin/kesiswaan/ppdb/syarat-ppdb?jalur_id=${jalurId}`)
    .then(res => res.json())
    .then(data => {
        syaratContainer.innerHTML = '';
        if(data.length === 0) {
            syaratContainer.innerHTML = 'Tidak ada syarat aktif untuk jalur ini';
            return;
        }
        data.forEach(s => {
            syaratContainer.innerHTML += `
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="syarat_${s.id}" name="documents[${s.id}]">
                    <label for="syarat_${s.id}">${s.syarat}</label>
                </div>`;
        });
    });
});

// Reset form untuk tambah baru
document.getElementById('btnResetForm').addEventListener('click', function() {
    document.getElementById('formulirId').reset();
    syaratContainer.innerHTML = 'Silahkan pilih jalur terlebih dahulu';
});
</script>

@endsection
