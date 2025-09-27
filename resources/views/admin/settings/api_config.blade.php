@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Sistem /</span> Pengaturan Web Service (View Only)</h4>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mb-4">
                <h5 class="card-header">Konfigurasi Domain & API Token</h5>
                <div class="card-body">
                    
                    {{-- ====================================== --}}
                    {{-- BAGIAN 1: PENGATURAN URL DOMAIN --}}
                    {{-- ====================================== --}}
                    <h6 class="mb-3 text-primary"><i class="bx bx-world me-1"></i> Pengaturan URL Domain Utama</h6>
                    <p class="text-muted small">URL yang digunakan sebagai alamat dasar aplikasi saat ini.</p>
                    
                    <div class="mb-4">
                        <label for="app_domain" class="form-label">Domain Aplikasi Utama</label>
                        <input type="text" class="form-control" 
                            id="app_domain" 
                            value="{{ $settings['app_domain'] ?? 'N/A' }}" 
                            readonly>
                        <div class="form-text">Data ini tersimpan di database.</div>
                    </div>

                    <hr class="my-4">

                    {{-- ====================================== --}}
                    {{-- BAGIAN 2: PENGATURAN TOKEN WEBSERVICE --}}
                    {{-- ====================================== --}}
                    <h6 class="mb-3 text-primary"><i class="bx bx-key me-1"></i> Global Web Service Token</h6>
                    <p class="text-muted small">Token ini digunakan oleh klien *stateless* untuk mengakses API.</p>

                    <div class="mb-3">
                        <label for="current_api_token" class="form-label">API Token Aktif (Sensor)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="current_api_token" 
                                value="{{ $settings['current_api_token'] }}" 
                                readonly>
                            <button type="button" class="btn btn-icon btn-secondary" disabled
                                    data-bs-toggle="tooltip" title="Aksi Dinonaktifkan">
                                <i class="bx bx-copy"></i>
                            </button>
                        </div>
                        <div class="form-text text-danger">Untuk mengubah atau melihat token mentah, hubungi administrator sistem.</div>
                    </div>

                    <div class="mb-4">
                        {{-- Tombol Regenerasi Token (Disabled) --}}
                        <button type="button" class="btn btn-warning" disabled>
                            <i class="bx bx-refresh"></i> Regenerasi Token (Disabled)
                        </button>
                    </div>
                    
                    <hr class="my-4">
                    
                    {{-- Tombol Simpan (Disabled) --}}
                    <button type="button" class="btn btn-secondary" disabled><i class="bx bx-save"></i> Simpan Pengaturan (Disabled)</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection