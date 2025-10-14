@extends('layouts.ppdb')

@section('content-ppdb')
    
    <!-- Formulir Pendaftaran Section (Daftar) - DENGAN PROGRESS BAR DINAMIS -->
        <section id="daftar" class="py-20 bg-gray-100">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="100"
                data-aos-duration="800">

                <div class="w-full bg-white shadow-2xl rounded-xl p-6 sm:p-10 border border-gray-100">

                    <!-- Judul Formulir (Sesuai Gambar) -->
                    <h1 class="text-3xl font-extrabold text-primary-blue mb-2">Pendaftaran Calon Siswa</h1>
                    <p class="text-gray-500 mb-8">Lengkapi semua langkah untuk menyelesaikan proses pendaftaran Anda.
                    </p>

                    <!-- PROGRESS BAR UTAMA -->
                    <div class="relative mb-12">
                        <!-- Garis Progres Abu-abu (Dasar) -->
                        <div
                            class="absolute w-full h-1 bg-neutral-light top-1/2 transform -translate-y-1/2 rounded-full">
                        </div>

                        <!-- Garis Progres Hijau (Terisi) - Diperbarui oleh JS -->
                        <div id="progressBar"
                            class="absolute h-1 bg-secondary-green top-1/2 transform -translate-y-1/2 rounded-full w-0"
                            style="width: 0%;"></div>

                        <!-- Kontainer untuk Lingkaran Langkah -->
                        <div id="stepIndicators" class="relative flex justify-between">
                            <!-- Konten dinamis akan dimasukkan di sini oleh JS -->
                        </div>
                    </div>

                    <form id="ppdb-form" class="space-y-6">
                        <!-- KONTEN FORMULIR PER LANGKAH -->
                        <div id="formContent" class="min-h-[350px] bg-neutral-light p-6 rounded-lg shadow-inner">
                            <!-- Konten dinamis akan dimasukkan di sini oleh JS -->
                            <div class="text-center text-gray-500 py-10">Memuat langkah formulir...</div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between pt-4">
                            <button type="button" id="prevBtn" onclick="prevStep()"
                                class="px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg shadow-md hover:bg-gray-400 transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed flex items-center">
                                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i> Sebelumnya
                            </button>

                            <button type="button" id="nextBtn" onclick="nextStep()"
                                class="px-6 py-3 bg-primary-blue text-white font-semibold rounded-lg shadow-lg hover:bg-blue-800 transition duration-150 flex items-center">
                                Lanjut <i data-lucide="arrow-right" class="w-5 h-5 ml-2"></i>
                            </button>

                            <button type="submit" id="submitBtn"
                                class="px-6 py-3 bg-secondary-green text-white font-bold rounded-lg shadow-lg transform hover:scale-[1.01] transition duration-300 hidden flex items-center">
                                Kirim Pendaftaran <i data-lucide="send" class="w-5 h-5 ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

@endsection