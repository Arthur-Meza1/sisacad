<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\AlumnoController;
use App\Infrastructure\Teacher\Controller\DocenteController;
use App\Infrastructure\Teacher\Controller as Teacher;
use App\Infrastructure\Admin\Controller as Admin;


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
// FIXME: (Alberto) Esto en serio deberia ser refactorizado en un solo controlador que retorne vistas en vez de JSON
Route::middleware(['auth', 'role:teacher'])
  ->prefix('/api/teacher')
  ->group(function () {
    Route::get("/horario", Teacher\GetHorarioController::class);
    Route::post('/aulas', Teacher\GetAulasDisponiblesController::class);
    Route::post('/sesion', Teacher\CreateOrGetSesionController::class);
    Route::post("/asistencia", Teacher\GuardarAsistenciaController::class)->name("asistencia.guardar");
  });

Route::middleware(['auth', 'role:admin'])
  ->prefix('/admin')->name('admin.')
  ->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
      ->name('dashboard');
    Route::prefix('users')->name('users.')
      ->group(function () {
        Route::get('/', [Admin\UserController::class, 'index'])->name('index');
        Route::get('/create', [Admin\UserController::class, 'create'])->name('create');
        Route::post('/', [Admin\UserController::class, 'store'])->name('store');
        Route::get('/search', [Admin\UserController::class, 'search'])->name('search');
      });
    Route::prefix('cursos')->name('cursos.')
      ->group(function () {
        Route::get('/', [Admin\CursoController::class, 'index'])->name('index');
      });
  });

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
