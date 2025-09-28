<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  {{-- Path ini penting untuk JS template, arahkan ke folder aset di public --}}
  data-assets-path="{{ asset('sneat/assets/') }}" 
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard Admin Sekolah</title>
    <meta name="description" content="" />

    {{-- Gunakan helper asset() untuk file di folder public --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    {{-- Panggil semua CSS dan JS yang dibutuhkan di <head> melalui Vite --}}
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
    @include('layouts.partials.toast')
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
    {{-- Panggil semua JS utama yang dibutuhkan sebelum </body> melalui Vite --}}
    @vite([
        'resources/sneat/assets/vendor/libs/jquery/jquery.js',
        'resources/sneat/assets/vendor/libs/popper/popper.js',
        'resources/sneat/assets/vendor/js/bootstrap.js',
        'resources/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
        'resources/sneat/assets/vendor/js/menu.js',
        'resources/sneat/assets/vendor/libs/apex-charts/apexcharts.js',
        'resources/sneat/assets/js/main.js',
        'resources/sneat/assets/js/dashboards-analytics.js',
        'resources/sneat/assets/js/ui-modals.js',
        'resources/sneat/assets/js/ui-toasts.js'
    ])
    
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>