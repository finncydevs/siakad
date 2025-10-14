@extends('layouts.ppdb')

@section('content-ppdb')
    
        <!-- Jurusan Section (Kompetensi Keahlian) -->
        <section id="jurusan" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 text-center mb-4" data-aos="fade-up"
                    data-aos-duration="600">
                    Pilihan Kompetensi Keahlian
                </h2>
                <p class="text-xl text-gray-600 text-center mb-16 max-w-3xl mx-auto" data-aos="fade-up"
                    data-aos-delay="100" data-aos-duration="600">
                    Temukan minat dan bakat Anda melalui 6 jurusan unggulan yang siap menyalurkan ke dunia kerja dan
                    kuliah.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="100">
                        <div class="flex items-center mb-4">
                            <i data-lucide="code" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">PPLG</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Pengembangan Perangkat Lunak dan GIM)</p>
                        <p class="text-gray-600 text-base">Fokus pada **pemrograman web, mobile, dan pembuatan game**.
                            Mempersiapkan siswa menjadi *developer* atau *programmer* handal di era digital.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="200">
                        <div class="flex items-center mb-4">
                            <i data-lucide="network" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">TJKT</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Teknik Jaringan Komputer dan
                            Telekomunikasi)</p>
                        <p class="text-gray-600 text-base">Mempelajari instalasi, konfigurasi, dan **manajemen jaringan
                            komputer (LAN/WAN)** serta teknologi fiber optik. Siap menjadi *Network Engineer*.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="300">
                        <div class="flex items-center mb-4">
                            <i data-lucide="calculator" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">AKL</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Akuntansi dan Keuangan Lembaga)</p>
                        <p class="text-gray-600 text-base">Melatih kemampuan **pembukuan, penyusunan laporan keuangan**,
                            dan mengoperasikan software akuntansi. Lulusan siap bekerja di bidang finansial.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="400">
                        <div class="flex items-center mb-4">
                            <i data-lucide="palette" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">DKV</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Desain Komunikasi Visual)</p>
                        <p class="text-gray-600 text-base">Kreativitas dalam **desain grafis, animasi, dan produksi
                            konten visual** untuk kebutuhan branding dan pemasaran modern (digital & cetak).</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="500">
                        <div class="flex items-center mb-4">
                            <i data-lucide="briefcase" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">MPLB</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Manajemen Perkantoran dan Layanan Bisnis)
                        </p>
                        <p class="text-gray-600 text-base">Fokus pada **administrasi perkantoran modern, keterampilan
                            sekretaris**, dan layanan pelanggan profesional berbasis teknologi.</p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg border-b-4 border-primary-blue hover:shadow-2xl transition duration-300 text-left h-full flex flex-col justify-start"
                        data-aos="zoom-in" data-aos-delay="600">
                        <div class="flex items-center mb-4">
                            <i data-lucide="car" class="w-8 h-8 text-primary-blue mr-3"></i>
                            <h3 class="text-xl font-bold text-gray-900">Otomotif</h3>
                        </div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">(Teknik Otomotif)</p>
                        <p class="text-gray-600 text-base">Keahlian dalam **perawatan, perbaikan, dan diagnosa sistem
                            mobil dan motor terbaru** dengan fokus pada teknologi kelistrikan kendaraan.</p>
                    </div>
                </div>
            </div>
        </section>

@endsection