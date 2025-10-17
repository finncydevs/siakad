import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Daftarkan semua file aset yang Anda gunakan di sini
            input: [
                // File default (bisa Anda hapus jika tidak digunakan)
                'resources/css/app.css',
                'resources/js/app.js',

                // File-file dari tema Sneat yang dibutuhkan oleh halaman login
                'resources/sneat/assets/vendor/fonts/boxicons.css',
                'resources/sneat/assets/vendor/css/core.css',
                'resources/sneat/assets/vendor/css/theme-default.css',
                'resources/sneat/assets/css/demo.css',
                'resources/sneat/assets/vendor/css/pages/page-auth.css',
            ],
            refresh: true,
        }),
    ],
});
