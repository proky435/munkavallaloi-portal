import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Minden IP címről elérhető
        port: 5173,
        cors: true, // CORS engedélyezése
        hmr: {
            host: '192.168.144.121', // A saját lokális IP címed
            port: 5173
        },
        // Fejlesztői szerver konfigurációk
        strictPort: false,
        origin: 'http://192.168.144.121:5173'
    }
});
