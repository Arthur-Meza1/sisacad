<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/form.css', 'resources/js/app.js'])
    @endif
</head>
<body>

<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('img/unsa_escudo.png') }}" alt="logo">
        <h2>Sistema Académico</h2>
    </div>

    <div class="user-info">
        <p>Universidad Nacional de San Agustín</p>
        <hr>
    </div>
</aside>

<div class="main-content login-container">
    {{ $slot }}
</div>
</body>
</html>
