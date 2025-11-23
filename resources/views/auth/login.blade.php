<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - UNSA</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      background: #f4f7f9;
    }

    .accent {
      background: linear-gradient(90deg, #06b6d4, #8b5cf6);
    }
  </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 via-blue-500 to-blue-800">

<div class="bg-white/20 backdrop-blur-xl shadow-2xl rounded-3xl p-10 w-full max-w-md text-white animate-fadeIn">

  <div class="text-center mb-6">
    <div class="mx-auto w-24 h-24 bg-white/30 rounded-2xl flex items-center justify-center shadow-xl mb-4 border border-white/40">
      <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#1E90FF" stroke-width="1.8"
           stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
        <path d="M4.73 20a8.94 8.94 0 0 1 14.54 0" />
      </svg>
    </div>
    <h1 class="text-3xl font-bold">Bienvenido</h1>
    <p class="text-white/80 text-sm">Inicia sesión para continuar</p>
  </div>

  <!-- FORMULARIO LARAVEL BLADE -->
  <form method="POST" action="/login" class="space-y-4">
    @csrf

    <!-- Email -->
    <div>
      <label for="email" class="block text-sm font-medium">Correo institucional</label>
      <input type="email"
             id="email"
             name="email"
             value="{{ old('email') }}"
             required
             autofocus
             placeholder="correo@ejemplo.com"
             class="mt-1 w-full rounded-xl p-3 bg-white/30 placeholder-white/70 text-white focus:outline-none focus:ring-2 focus:ring-white">

      @error('email')
      <div class="text-red-300 mt-1 text-sm">{{ $message }}</div>
      @enderror
    </div>

    <!-- Password -->
    <div>
      <label for="password" class="block text-sm font-medium">Contraseña</label>
      <input type="password"
             id="password"
             name="password"
             required
             placeholder="••••••••"
             class="mt-1 w-full rounded-xl p-3 bg-white/30 placeholder-white/70 text-white focus:outline-none focus:ring-2 focus:ring-white">

      @error('password')
      <div class="text-red-300 mt-1 text-sm">{{ $message }}</div>
      @enderror
    </div>

    <!-- Remember -->
    <div class="flex items-center space-x-2">
      <input type="checkbox"
             id="remember"
             name="remember"
             class="w-4 h-4"
        {{ old('remember') ? 'checked' : '' }}>
      <label for="remember" class="text-sm">Recuérdame</label>
    </div>

    <!-- Submit -->
    <button type="submit"
            class="w-full py-3 rounded-xl bg-white/30 hover:bg-white/40 text-white font-semibold transition shadow-lg">
      Ingresar
    </button>
  </form>

  <p class="text-center mt-4 text-white/80 text-sm hover:text-white cursor-pointer">
    ¿Olvidaste tu contraseña?
  </p>
</div>

</body>

</html>
