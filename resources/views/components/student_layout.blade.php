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
<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('img/unsa_escudo.png') }}" alt="logo">
        <h2>Sistema Académico</h2>
    </div>

    <div class="user-info">
        <h3>{{ auth()->user()->name }}</h3>
        <p>{{ auth()->user()->role }}</p>
        <hr>
    </div>
    <nav>
        <button onclick="cargarModulo('inicio')" class="activo">🏠 Inicio</button>
        <button onclick="cargarModulo('pases')">🎫 Pases</button>
        <button onclick="cargarModulo('opciones')">⚙️ Opciones</button>
        <button onclick="cargarModulo('informes')">📊 Informes</button>
    </nav>
</aside>
{{ $slot }}
</body>
</html>
