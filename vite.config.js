import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                 'resources/js/app.js',
                 'resources/sneat/assets/vendor/css/core.css',
                'resources/sneat/assets/vendor/css/theme-default.css',
                'resources/sneat/assets/css/demo.css',
                'resources/sneat/assets/vendor/js/helpers.js',
                'resources/sneat/assets/js/config.js',
                'resources/sneat/assets/vendor/libs/jquery/jquery.js',
                'resources/sneat/assets/vendor/libs/popper/popper.js',
                'resources/sneat/assets/vendor/js/bootstrap.js',
                'resources/sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
                'resources/sneat/assets/vendor/js/menu.js',
                'resources/sneat/assets/js/main.js',

            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
