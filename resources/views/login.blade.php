<x-layout>
    <x-slot:title>

    </x-slot:title>
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

                <p class="error-message" id="error-message" style="display: none;">Credenciales incorrectas. Intente de
                    nuevo.</p>

            </form>

            <p class="enlace-publico"><a href="/">Menú de Matrículas</a></p>
        </section>
    </main>
</x-layout>
