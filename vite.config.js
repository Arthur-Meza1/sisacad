import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/css/app.css',
              'resources/js/app.js',
              'resources/js/alumno/notas.js',
              'resources/js/alumno/calendario.js',
              'resources/js/docente/docente.js',
              'resources/js/docente/notas.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
