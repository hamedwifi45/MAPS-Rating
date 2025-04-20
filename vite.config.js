import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            build: {
                manifest: true,
            },
        }),
    ],
    server: {
        host: 'maps-rating.test', // نطاق Laragon
        port: 5173,
        hmr: {
            host: 'maps-rating.test', // نفس النطاق
        },
        cors: {
            origin: 'http://maps-rating.test', // اسمح بطلبات من هذا النطاق
        },
    },
});
