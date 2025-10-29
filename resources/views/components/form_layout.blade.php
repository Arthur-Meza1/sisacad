<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Sistema Academico') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/form.css', 'resources/css/form.css', 'resources/js/app.js'])
    @endif
</head>
<body>


<div class="main-content login-container">
    {{ $slot }}
</div>
</body>
</html>
