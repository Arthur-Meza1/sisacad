<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Infrastructure\Student\Controller as Student;
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
  /*Route::get('/student', Student\AlumnoController::class)
    ->name('student')
    ->middleware('role:student');*/
  // TODO: Secretary view missing
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
Route::middleware(['auth', 'role:teacher'])->prefix('/api/teacher')
  ->group(function () {
    Route::get("/horario", Teacher\GetHorarioController::class);
    Route::get("/grupo/{grupoId}/notas", Teacher\GetNotasController::class);
    Route::post("/notas/guardar", Teacher\GuardarNotasController::class);
    Route::get("/sesion/{id}", Teacher\GetSesionController::class);
    Route::get("/libreta/descargar", Teacher\LibretaDescargarController::class);
    Route::post('/aulas', Teacher\GetAulasDisponiblesController::class);
    Route::post('/crear_sesion', Teacher\CreateSesionController::class);
    Route::post("/sesion/{sesion}/guardar", Teacher\GuardarSesionController::class)->middleware('role:teacher')->name("asistencia.guardar");
    Route::post('/sesion/{sesion}/borrar', Teacher\BorrarSesionController::class)->middleware('role:teacher');
  });

Route::middleware(['auth', 'role:student'])->prefix('/api/student')
  ->group(function () {
    Route::get('/cursos', Student\GetCursosController::class);
    Route::get('/cursos/{curso}/notas', Student\GetNotasController::class);
    Route::post('/matricular', Student\MatricularController::class);
    Route::post('/desmatricular', Student\DesmatricularController::class);
  });


Route::middleware(['auth', 'role:teacher'])->prefix('/teacher')->name("teacher.")
  ->group(function () {
    Route::get('/', Teacher\DocenteController::class)
      ->name('dashboard');
    Route::get('/libreta', Teacher\LibretaController::class)
      ->name('libreta');
    Route::get('/horario', Teacher\HorarioController::class)
      ->name('horario');
    Route::get('/notas', Teacher\NotasController::class)
      ->name('notas');
  });

Route::middleware(['auth', 'role:student'])->prefix('/student')->name("student.")
  ->group(function () {
    Route::get('/', Student\AlumnoController::class)
      ->name('dashboard');
    Route::get('/matricula', Student\MatriculaController::class)
      ->name('matricula');
    Route::get('/horario', Student\HorarioController::class)
      ->name('horario');
    /*
    Route::get('/notas', Teacher\NotasController::class)
      ->name('notas');*/
  });

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')
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
