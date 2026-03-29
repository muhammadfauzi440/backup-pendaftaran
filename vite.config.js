import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({    
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/cek-status.js',
                'resources/js/scroll.js',
                'resources/js/daftar.js',
                'resources/js/kelompok.js',
                'resources/js/copy.js',
                'resources/js/bulk-delete.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
