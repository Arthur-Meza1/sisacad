<?php

namespace App\Services;

use App\Models\Alumno;

class AlumnoService {
  private $horarioService;

  public function __construct() {
    $this->horarioService = new HorarioService();
  }

  public function getCursosFromId($id) {
    $alumno = Alumno::where('user_id', $id)->firstOrFail();

    return
      $alumno->grupos()
        ->where('tipo', 'teoria')
        ->with('curso')
        ->get()
        ->map(fn ($grupo) => ['id' => $grupo->id, 'nombre' => $grupo->curso->nombre]);
  }

  public function getNotasCursoFromId($id, $curso) {
    $alumno = Alumno::where('user_id', $id)->firstOrFail();
    $notas = $alumno->registros()
      ->where('grupo_curso_id', $curso)
      ->first();

    return [
      'Parcial' =>  $notas->getNotasParcial(),
      'Continua' => $notas->getNotasContinua(),
    ];
  }

  public function getHorarioFromId($id) {
    return $this->horarioService->get(Alumno::class, $id, false);
  }
}
