@php
$title = 'Panel - ' . match (auth()->user()->role) {
            'teacher' => 'Docente',
            'student' => 'Estudiante',
            default => 'Usuario',
          };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css'])
  @endif
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
  <header class="p-4 bg-white shadow-md fixed w-full z-10">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl accent flex items-center justify-center text-white font-extrabold text-xl">U</div>
        <div>
          <h1 class="text-xl font-bold text-gray-800">{{$title}}</h1>
          <p class="text-xs text-gray-500">Bienvenido {{ auth()->user()->name }}</p>
        </div>
      </div>
      <a>
        <form class method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" title="Cerrar sesión" class="px-4 py-2 rounded-lg text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Cerrar sesión
          </button>
        </form>
      </a>
    </div>
  </header>

  <div class="flex flex-1 pt-20 max-w-7xl mx-auto w-full">
    {{ $slot }}
  </div>
</body>
</html>

