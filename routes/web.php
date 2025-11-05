<?php

use App\Http\Controllers\DocenteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\AlumnoController;

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    // Redirect based on authenticated user's role
    return match (auth()->user()->role) {
        'admin' => redirect('/admin'),
        'teacher' => redirect('/teacher'),
        'secretary' => redirect('/secretary'),
        'student' => redirect('/student'),
        default => redirect('/login'),
    };
});

Route::middleware('auth')->group(function () {
    Route::get('/student', [AlumnoController::class, 'index'])->middleware('role:student');
    Route::view('/admin', 'admin')->middleware('role:admin');
  Route::get('/teacher', [DocenteController::class, 'index'])->middleware('role:teacher');
    Route::view('/secretary', 'secretary')->middleware('role:secretary');
});

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');
Route::post('/login', Login::class)
    ->middleware('guest');
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');
