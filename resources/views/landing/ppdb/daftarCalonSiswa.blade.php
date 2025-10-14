@extends('layouts.ppdb')

@section('content-ppdb')
    

        <!-- Daftar Calon Siswa Section (Tabel Real-Time) -->
        <section id="daftar-siswa-list" class="py-20 bg-neutral-light">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4" data-aos="fade-up">
                    Daftar Calon Siswa PPDB
                </h2>
                <p class="text-xl text-gray-600 mb-12 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                    Data ini menampilkan pendaftar yang telah berhasil mengirimkan formulir dan diverifikasi. Daftar
                    diperbarui secara real-time.
                </p>

                <!-- Table Container yang akan diisi oleh JavaScript -->
                <div id="applicants-table-container" class="mt-8" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-center py-10 bg-white rounded-xl shadow-md">
                        <i data-lucide="loader-circle" class="w-8 h-8 text-primary-blue mx-auto mb-3 animate-spin"></i>
                        <p class="text-gray-700">Memuat data pendaftar...</p>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-xs text-gray-400 mt-1">ID Sesi Pengguna: <span id="user-id-display">Memuat...</span>
                    </p>
                </div>
            </div>
        </section>

@endsection