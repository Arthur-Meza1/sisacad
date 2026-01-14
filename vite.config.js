import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
              'resources/css/app.css',
              'resources/js/app.js',
              'resources/js/bootstrap.js',
              'resources/js/admin/admin.js',
              'resources/js/alumno/calendario.js',
              'resources/js/alumno/notas.js',
              'resources/js/common/ContentLoader.js',
              'resources/js/docente/plots/boxplot.js',
              'resources/js/docente/plots/flechas.js',
              'resources/js/docente/plots/histograma.js',
              'resources/js/docente/plots/scatter.js',
              'resources/js/docente/asistencia.js',
              'resources/js/docente/calendario.js',
              'resources/js/docente/docente.js',
              'resources/js/docente/libreta.js',
              'resources/js/docente/notas.js',
              'resources/js/shared/calendario.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
