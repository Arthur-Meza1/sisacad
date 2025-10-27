<x-layout>
    <x-slot:title>
        Register
    </x-slot:title>

    <div class="login-container">
        <div class="login-box block">
            <div class="block-title title-rojo">Create Account</div>

            <form method="POST" action="/register">
                @csrf

                <!-- Name -->
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           placeholder="John Doe"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text"
                           id="email"
                           name="email"
                           placeholder="mail@example.com"
                           value="{{ old('email') }}"
                           required>
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

                <!-- Confirm Password -->
                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="••••••••"
                           required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="system-button full-width">
                    Register
                </button>
            </form>

            <div class="enlace-publico">
                <p>Already have an account? <a href="/login">Sign in here</a></p>
            </div>
        </div>
    </div>
</x-layout>
