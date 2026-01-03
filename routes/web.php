<?php

use App\Http\Controllers\Auth as Auth;
use App\Infrastructure\Admin\Controller as Admin;
use App\Infrastructure\Student\Controller as Student;
use App\Infrastructure\Teacher\Controller as Teacher;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  if (!auth()->check()) {
    return redirect()->route('login');
  }

  return match (auth()->user()->role) {
    'admin' => redirect('/admin'),
    'teacher' => redirect('/teacher'),
    'secretary' => redirect('/secretary'),
    'student' => redirect('/student')
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
Route::post('/login', Auth\Login::class)
  ->middleware('guest');
Route::post('/logout', Auth\Logout::class)
  ->middleware('auth')
  ->name('logout');

Route::prefix('/student')->name('student.')->group(function () {
  Route::get('/', Student\IndexController::class)->name('index');
  Route::get('/matricula', Student\MatriculaController::class)->name('matricula');
  Route::get('/horario', Student\HorarioController::class)->name('horario');
  Route::get('/notas', Student\NotasController::class)->name('notas');
  Route::get('/asistencias', Student\AsistenciasController::class)->name('asistencias');
})->middleware(['auth', 'role:student']);

Route::prefix('/api/student')->group(function () {
  Route::get('/cursos/{curso}/notas', Student\GetNotasController::class);
  Route::post('/matricular', Student\MatricularController::class);
  Route::post('/desmatricular', Student\DesmatricularController::class);
});

Route::prefix('/api/teacher')->group(function () {
  Route::get("/grupo/{grupoId}/notas", Teacher\GetNotasController::class);
  Route::post("/notas/guardar", Teacher\GuardarNotasController::class);
  Route::get("/sesion/{id}", Teacher\GetSesionController::class);
  Route::get('/libreta/descargar', Teacher\LibretaDescargarController::class)
    ->name('teacher.libreta.descargar');
  Route::post('/aulas', Teacher\GetAulasDisponiblesController::class);
  Route::post('/crear_sesion', Teacher\CreateSesionController::class);
  Route::post("/sesion/{sesion}/guardar", Teacher\GuardarSesionController::class)
    ->name("asistencia.guardar");
  Route::post('/sesion/{sesion}/borrar', Teacher\BorrarSesionController::class);
})->middleware(['auth', 'role:teacher']);

Route::prefix('teacher')->name("teacher.")->group(function () {
  Route::get('/', Teacher\IndexController::class)->name('index');
  Route::prefix('libreta')->name('libreta.')->group(function () {
    Route::get('/', Teacher\LibretaIndexController::class)->name('index');
    Route::get('/{grupo}', Teacher\LibretaEditorController::class)->name('editor');
  });
  Route::prefix('horario')->name('horario.')->group(function () {
    Route::get('/', Teacher\HorarioController::class)->name('index');
    Route::get('reservar', Teacher\ReservarController::class)->name('reservar');
    // Route::get('asistencia', Teacher\AsistenciaController::class)->name('asistencia');
  });
  Route::get('notas', Teacher\NotasController::class)->name('notas');
})->middleware(['auth', 'role:teacher']);

Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('/', Admin\IndexController::class)->name('index');
  Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [Admin\UserController::class, 'index'])->name('index');
    Route::get('create', [Admin\UserController::class, 'create'])->name('create');
    Route::post('/', [Admin\UserController::class, 'store'])->name('store');
    Route::get('search', [Admin\UserController::class, 'search'])->name('search');
  });
  Route::prefix('cursos')->name('cursos.')->group(function () {
    Route::get('/', [Admin\CursoController::class, 'index'])->name('index');
    Route::get('search', [Admin\CursoController::class, 'search'])->name('search');
  });
})->middleware(['auth', 'role:admin']);
