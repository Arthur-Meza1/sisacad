<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
<div class="sidebar">
    <div class="user-profile">
        <div class="user-avatar"><i class="fas fa-user-graduate"></i></div>
        <h3>{{ auth()->user()->name }}</h3>
        <p>{{ auth()->user()->role }}</p>
    </div>
    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" title="Cerrar sesión" style="background:none; border:none; cursor:pointer; font-size:16px;">
            ⏻ Logout
        </button>
    </form>
    <nav class="navigation">
        {{ $nav_options }}
    </nav>
</div>
{{ $slot }}
</body>
</html>

