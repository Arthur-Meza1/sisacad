<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <header class="header">
            <div class="logo">
                <img src="{{ asset('img/unsa_escudo.png') }}" alt="Logo Universidad Nacional San Agustín">
                <h1>UNIVERSIDAD NACIONAL SAN AGUSTÍN</h1>
            </div>
            <div class="title-right">
                <h2>Matrículas 2025-B</h2>
            </div>
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="content-container">
                <section class="block documentos">
                    <h3 class="block-title title-rojo">PROCEDIMIENTOS Y DOCUMENTOS</h3>
                    <ul>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Reglamento de Matrículas</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Cronograma Académico 2025</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Pautas Matrícula 2025-B</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Pautas Matrícula por excepción 2025-B</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Ficha de Matrícula (matr. por excepción)</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Evaluación por Jurado 2025-B</a></li>
                        <li><i class="check-icon">✓</i> <a href="/" target="_blank">Pautas cierre de matrículas 2025-B</a></li>
                    </ul>
                </section>
                <section class="block sistemas">
                    <h3 class="block-title title-rojo">Sistemas en línea</h3>
                    <nav class="system-links">
                        <a href="" class="system-button">Cronograma de Matrículas</a>
                        <a href="" class="system-button">Descarga de Talón de Pago</a>
                        <a href="" class="system-button">Matrículas en Línea</a>

                        <a href="" class="system-button">Libreta de Notas</a>
                        <a href="" class="system-button">Encuesta Evaluación Docente</a>
                        <a href="" class="system-button">Encuesta Defensoría Universitaria</a>
                        <a href="" class="system-button">Encuesta Estudios Generales</a>
                        <a href="" class="system-button">Laboratorio de Física</a>
                    </nav>
                </section>

            </main>
        </div>
    </body>
</html>
