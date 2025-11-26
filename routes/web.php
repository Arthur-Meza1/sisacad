<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\AlumnoController;
use App\Infrastructure\Teacher\Controller\DocenteController;
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
  Route::get('/teacher', DocenteController::class)
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

// =============
// API
// =============
// FIXME: Por alguna razon si lo coloco en api.php no funca los middleware
Route::get("api/teacher/horario", \App\Infrastructure\Teacher\Controller\GetHorarioController::class)->middleware('role:teacher');
// Route::get("api/teacher/curso/{curso}/alumnos", \App\Infrastructure\Teacher\Controller\GetHorarioController::class)->middleware('role:teacher');
Route::post('/api/teacher/aulas', \App\Infrastructure\Teacher\Controller\GetAulasDisponiblesController::class)->middleware('role:teacher');
Route::post('/api/teacher/sesion', \App\Infrastructure\Teacher\Controller\CreateOrGetSesionController::class)->middleware('role:teacher');

/*Route::get('/docente/registrar-notas', [DocenteController::class, 'registrarNotas'])
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
Route::get('/api/student/horario', [AlumnoController::class, 'getHorario'])->middleware('role:student');
Route::get('/api/student/cursos/{curso}/notas', [AlumnoController::class, 'getNotasCurso'])->middleware('role:student');
Route::get('/api/student/cupos', [AlumnoController::class, 'getCuposMatricula'])->middleware('role:student');
Route::get('/api/student/labs', [AlumnoController::class, 'getLaboratorios'])->middleware('role:student');

Route::post('/api/teacher/sesion', [DocenteController::class, 'crearSesion'])->middleware('role:teacher');
Route::post('/api/student/matricular', [AlumnoController::class, 'matricular'])->middleware('role:student');*/
