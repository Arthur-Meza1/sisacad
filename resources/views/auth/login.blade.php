<x-form_layout>
    <x-slot:title>
        Ingresar
    </x-slot:title>

    <div class="login-container">
        <div class="login-box block">
            <div class="block-title">Ingresar</div>

            <form method="POST" action="/login">
                @csrf

                <div class="input-group">
                    <label for="email">Correo</label>
                    <input type="text"
                           id="email"
                           name="email"
                           placeholder="correo@ejemplo.com"
                           value="{{ old('email') }}"
                           required
                           autofocus>
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

                <div class="input-group">
                    <label>
                        <input type="checkbox"
                               name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        Recuérdame
                    </label>
                </div>

                <button type="submit" class="system-button full-width">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</x-form_layout>
