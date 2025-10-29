<x-form_layout>
    <x-slot:title>
        Registrar usuario
    </x-slot:title>

    <div class="login-container">
        <div class="login-box block">
            <div class="block-title">Resgistrar usuario</div>

            <form method="POST" action="/register">
                @csrf

                <div class="input-group">
                    <label for="name">Nombre</label>
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="Juan Perez"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="email">Correo</label>
                    <input type="text"
                           id="email"
                           name="email"
                           placeholder="correo@ejemplo.com"
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="••••••••"
                           required>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="••••••••"
                           required>
                </div>

                <button type="submit" class="system-button full-width">
                    Registrar
                </button>
            </form>
        </div>
    </div>
</x-form_layout>
