<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            return match ($user->role) {
                'admin' => redirect()->intended('/admin'),
                'teacher' => redirect()->intended('/teacher'),
                'secretary' => redirect()->intended('/secretary'),
                'student' => redirect()->intended('/student'),
                default => redirect()->intended('/login'),
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->onlyInput('email');
    }
}
