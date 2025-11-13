<?php

use App\Http\Controllers\DocenteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AsistenciaController;

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
  Route::get('/student', [AlumnoController::class, 'index'])
    ->name('student')
    ->middleware('role:student');
  Route::view('/admin', 'admin')->middleware('role:admin');
  Route::get('/teacher', [DocenteController::class, 'index'])
    ->name('teacher')
    ->middleware('role:teacher');
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

Route::get('/docente/registrar-notas', [DocenteController::class, 'registrarNotas'])
  ->name('docente.registrar_notas')
  ->middleware('role:teacher');
Route::post('/docente/registrar-notas/{grupoId}', [DocenteController::class, 'guardarNotas'])
  ->name('docente.guardar_notas')
  ->middleware('role:teacher');


Route::get('/docente/asistencia', [AsistenciaController::class, 'index'])
  ->name('asistencia.index')
  ->middleware('role:teacher');
Route::get('/docente/asistencia/{grupo}', [AsistenciaController::class, 'mostrarFormulario'])
  ->name('asistencia.form')
  ->middleware('role:teacher');
Route::post('/docente/asistencia/{grupo}', [AsistenciaController::class, 'guardarAsistencia'])
  ->name('asistencia.guardar')
  ->middleware('role:teacher');

Route::get('/api/student/cursos', [AlumnoController::class, 'getCursos'])->middleware('role:student');
Route::get('/api/student/cursos/{curso}/notas', [AlumnoController::class, 'getNotasCurso'])->middleware('role:student');
