<x-layout>
    <x-slot:title>
        Sign In
    </x-slot:title>

    <div class="login-container">
        <div class="login-box block">
            <div class="block-title title-rojo">Sign In</div>

            <form method="POST" action="/login">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text"
                           id="email"
                           name="email"
                           placeholder="mail@example.com"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    @error('email')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="••••••••"
                           required>
                    @error('password')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="input-group">
                    <label>
                        <input type="checkbox"
                               name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="system-button full-width">
                    Sign In
                </button>
            </form>

            <div class="enlace-publico">
                <p>Don't have an account? <a href="/register">Register here</a></p>
            </div>
        </div>
    </div>
</x-layout>
