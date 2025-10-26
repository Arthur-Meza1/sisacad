<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles / Scripts -->
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
                <h2>Acceso al Sistema</h2>
            </div>
        </header>
        <main class="login-container">
            <section class="login-box block">
                <h3 class="block-title title-rojo">INICIO DE SESIÓN</h3>

                <form id="loginForm">

                    <div class="input-group">
                        <label for="username">Usuario (CUI o Correo):</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="system-button full-width">ENTRAR AL SISTEMA</button>

                    <p class="error-message" id="error-message" style="display: none;">Credenciales incorrectas. Intente de nuevo.</p>

                </form>

                <p class="enlace-publico"><a href="/">Menú de Matrículas</a></p>
            </section>

        </main>
        <script src="login-simulation.js"></script>
    </body>
</html>
