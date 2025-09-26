<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat/assets/') }}" 
  data-template="vertical-menu-template-free"
>
  <head>
    {{-- ... (Isi <head> tidak ada perubahan) ... --}}
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <title>Dashboard Admin Sekolah</title>
    {{-- ... --}}
    @vite([
        'resources/sneat/assets/vendor/fonts/boxicons.css',
        'resources/sneat/assets/vendor/css/core.css',
        'resources/sneat/assets/vendor/css/theme-default.css',
        'resources/sneat/assets/css/demo.css',
        'resources/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css',
        'resources/sneat/assets/vendor/libs/apex-charts/apex-charts.css',
        'resources/sneat/assets/vendor/js/helpers.js',
        'resources/sneat/assets/js/config.js'
    ])
  </head>
  <body>
    <!-- WADAH TOAST -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
        {{-- Toast Sukses (Hijau) --}}
        <div id="successToast" class="bs-toast toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Sukses</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="successToastBody"></div>
        </div>
        {{-- Toast Gagal (Merah) --}}
        <div id="errorToast" class="bs-toast toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Gagal</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="errorToastBody"></div>
        </div>
        {{-- Toast Info (Abu-abu) - BARU --}}
        <div id="infoToast" class="bs-toast toast bg-secondary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-info-circle me-2"></i>
                <div class="me-auto fw-semibold">Informasi</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="infoToastBody"></div>
        </div>
    </div>
    <!-- AKHIR DARI WADAH TOAST -->

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('layouts.partials.sidebar')
            <div class="layout-page">
                @include('layouts.partials.topbar')
                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    @include('layouts.partials.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    @vite([
        'resources/sneat/assets/vendor/libs/jquery/jquery.js',
        'resources/sneat/assets/vendor/libs/popper/popper.js',
        'resources/sneat/assets/vendor/js/bootstrap.js',
        'resources/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
        'resources/sneat/assets/vendor/js/menu.js',
        'resources/sneat/assets/vendor/libs/apex-charts/apexcharts.js',
        'resources/sneat/assets/js/main.js',
        'resources/sneat/assets/js/dashboards-analytics.js'
    ])
    
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                const successToast = document.getElementById('successToast');
                const successToastBody = document.getElementById('successToastBody');
                successToastBody.innerHTML = "{{ session('success') }}";
                const toast = new bootstrap.Toast(successToast);
                toast.show();
            @endif

            @if(session('error'))
                const errorToast = document.getElementById('errorToast');
                const errorToastBody = document.getElementById('errorToastBody');
                errorToastBody.innerHTML = "{{ session('error') }}";
                const toast = new bootstrap.Toast(errorToast);
                toast.show();
            @endif

            {{-- Logika untuk Toast Info - BARU --}}
            @if(session('info'))
                const infoToast = document.getElementById('infoToast');
                const infoToastBody = document.getElementById('infoToastBody');
                infoToastBody.innerHTML = "{{ session('info') }}";
                const toast = new bootstrap.Toast(infoToast);
                toast.show();
            @endif
        });
    </script>
    @stack('scripts')
  </body>
</html>

