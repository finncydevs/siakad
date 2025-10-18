@extends('layouts.ppdb')

@section('content-ppdb')
<section id="daftar-siswa-list" class="py-20 bg-neutral-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4" data-aos="fade-up">
            Daftar Calon Siswa PPDB
        </h2>
        <p class="text-xl text-gray-600 mb-12 max-w-4xl mx-auto" data-aos="fade-up" data-aos-delay="100">
            Data ini menampilkan pendaftar yang telah berhasil mengirimkan formulir dan diverifikasi. Daftar diperbarui secara real-time.
        </p>

        <div id="applicants-table-container" class="mt-8" data-aos="fade-up" data-aos-delay="200">
            <!-- Loading Spinner -->
            <div id="loading" class="text-center py-10 bg-white rounded-xl shadow-md">
                <i data-lucide="loader-circle" class="w-8 h-8 text-primary-blue mx-auto mb-3 animate-spin"></i>
                <p class="text-gray-700">Memuat data pendaftar...</p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-xs text-gray-400 mt-1">ID Sesi Pengguna: <span id="user-id-display">Memuat...</span></p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('applicants-table-container');
    const loading = document.getElementById('loading');

    function fetchApplicants() {
        fetch("{{ route('ppdb.daftarCalonSiswa') }}", { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' } 
        })
        .then(res => res.json())
        .then(data => {
            const applicants = data.applicants;
            loading.style.display = 'none';

            if (!applicants || applicants.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-10 bg-white rounded-xl shadow-md border-b-4 border-secondary-green">
                        <i data-lucide="info" class="w-8 h-8 text-primary-blue mx-auto mb-3"></i>
                        <p class="text-xl font-semibold text-gray-700">Belum ada pendaftar.</p>
                        <p class="text-gray-500">Ayo segera daftar dan muncul di daftar ini!</p>
                    </div>
                `;
                return;
            }

            // Buat tabel
            let rows = '';
            applicants.forEach((applicant, index) => {
                const rowClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                rows += `
                    <tr class="${rowClass} hover:bg-yellow-50/50 transition duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">${index + 1}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-bold text-primary-blue">
                            ${applicant.registration_number}    
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">${applicant.nisn || '-'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-700">${applicant.nama_lengkap}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">${applicant.asal_sekolah || '-'}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-secondary-green">${applicant.jurusan || '-'}</td>
                    </tr>
                `;
            });

            container.innerHTML = `
                <div class="overflow-x-auto bg-white rounded-xl shadow-2xl shadow-primary-blue/20 border border-gray-100">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-blue text-white text-center">
                            <tr>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">No. Urut</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">No. Pendaftaran</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">NISN</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">Nama Lengkap</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">Asal Sekolah</th>
                                <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider">Jurusan Dipilih</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            ${rows}
                        </tbody>
                    </table>
                </div>
                <p class="text-sm text-gray-500 mt-6 text-center">
                    Total Pendaftar Saat Ini: <span class="font-bold text-lg text-primary-blue">${applicants.length}</span>
                </p>
                <p class="text-xs text-gray-400 mt-1 text-center">
                    Data diperbarui secara real-time dari database.
                </p>
            `;
        })
        .catch(err => {
            console.error(err);
            loading.innerHTML = `
                <div class="text-center py-10 bg-white rounded-xl shadow-md border-b-4 border-red-500">
                    <i data-lucide="alert-triangle" class="w-8 h-8 text-red-500 mx-auto mb-3"></i>
                    <p class="text-xl font-semibold text-gray-700">Gagal memuat data!</p>
                    <p class="text-gray-500">Periksa koneksi internet atau hubungi admin.</p>
                </div>
            `;
        });
    }

    fetchApplicants();
    setInterval(fetchApplicants, 10000);
});
</script>
@endsection
