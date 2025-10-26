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
        <h2>{{ $title }}</h2>
    </div>
</header>
{{ $slot }}
</body>
</html>
