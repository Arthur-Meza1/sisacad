<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Infrastructure\Student\Controller\AlumnoController;
use App\Infrastructure\Teacher\Controller\DocenteController;
use App\Infrastructure\Admin\Controller\UserController;
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
  Route::get('/student', AlumnoController::class)
    ->name('student')
    ->middleware('role:student');
  Route::get('/admin', [DashboardController::class, 'index'])
    ->middleware('role:admin')
    ->name('admin.dashboard');
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
// =============cal
// FIXME: Por alguna razon si lo coloco en api.php no funca los middleware
Route::get("/api/teacher/horario", \App\Infrastructure\Teacher\Controller\GetHorarioController::class)->middleware('role:teacher');
Route::get("/api/teacher/{grupo}/notas", \App\Infrastructure\Teacher\Controller\GetNotasController::class)->middleware('role:teacher');
Route::get('/api/teacher/sesion/{sesion}', \App\Infrastructure\Teacher\Controller\GetSesionController::class)->middleware('role:teacher');
Route::post('/api/teacher/aulas', \App\Infrastructure\Teacher\Controller\GetAulasDisponiblesController::class)->middleware('role:teacher');
Route::post('/api/teacher/crear_sesion', \App\Infrastructure\Teacher\Controller\CreateSesionController::class)->middleware('role:teacher');
Route::post("/api/teacher/asistencia", \App\Infrastructure\Teacher\Controller\GuardarAsistenciaController::class)->middleware('role:teacher')->name("asistencia.guardar");

Route::middleware(['auth', 'role:admin'])
  ->prefix('admin/users')
  ->name('admin.users.')
  ->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/search', [UserController::class, 'search'])->name('search');
  });
Route::get("/api/student/horario", \App\Infrastructure\Student\Controller\GetHorarioController::class)->middleware('role:student');
Route::get('/api/student/cursos', \App\Infrastructure\Student\Controller\GetCursosController::class)->middleware('role:student');
Route::get('/api/student/cursos/{curso}/notas', \App\Infrastructure\Student\Controller\GetNotasController::class)->middleware('role:student');
Route::get('/api/student/cupos', \App\Infrastructure\Student\Controller\GetCuposController::class)->middleware('role:student');
Route::get('/api/student/labs', \App\Infrastructure\Student\Controller\GetLabsController::class)->middleware('role:student');
Route::post('/api/student/matricular', \App\Infrastructure\Student\Controller\MatricularController::class)->middleware('role:student');
Route::post('/api/student/desmatricular', \App\Infrastructure\Student\Controller\DesmatricularController::class)->middleware('role:student');

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


Route::post('/api/teacher/sesion', [DocenteController::class, 'crearSesion'])->middleware('role:teacher');
Route::post('/api/student/matricular', [AlumnoController::class, 'matricular'])->middleware('role:student');*/
