<?php
use Illuminate\Support\Facades\Route;
use App\Infrastructure\Teacher\Controller as Teacher;

Route::prefix('teacher')->group(function () {
  Route::get("/grupo/{grupoId}/notas", Teacher\GetNotasController::class);
  Route::post("/notas/guardar", Teacher\GuardarNotasController::class);
  Route::get("/sesion/{id}", Teacher\GetSesionController::class);
  Route::get('/libreta/descargar', Teacher\LibretaDescargarController::class)
    ->name('teacher.libreta.descargar');
  Route::get('/silabo/plantilla', Teacher\SilaboPlantillaController::class)
    ->name('teacher.silabo.plantilla');
  Route::post('/aulas', Teacher\GetAulasDisponiblesController::class);
  Route::post('/crear_sesion', Teacher\CreateSesionController::class);
  Route::post("/sesion/{sesion}/guardar", Teacher\GuardarSesionController::class)
    ->name("asistencia.guardar");
  Route::post('/sesion/{sesion}/borrar', Teacher\BorrarSesionController::class);
});
