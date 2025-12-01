<?php

namespace App\Services;

use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Student\Model\Alumno;

class AlumnoService {
  private $horarioService;

  public function __construct() {
    $this->horarioService = new HorarioService();
  }


  public function getGroupDataFromId($id) {
    $alumno = Alumno::with('grupos.curso', "grupos.docente.user", "grupos.bloqueHorario")
      ->where('user_id', $id)->firstOrFail();

    return $alumno->grupos
      ->map(fn ($grupo) => [
          "docente" => $grupo->docente->user->name,
          "nombre" => $grupo->curso->nombre,
          "tipo" => $grupo->tipo,
          "turno" => $grupo->turno,
          "horario" => optional($grupo->bloqueHorario->first())->only(['horaInicio', 'horaFin']),
      ]);
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

  public function getCuposDisponibles($id) {
    $alumno = Alumno::with('grupos.curso')
      ->where('user_id', $id)
      ->firstOrFail();

    // Todos los grupos del alumno
    $gruposAlumno = $alumno->grupos->pluck('id');

    // Cursos teóricos del alumno
    $teorias = $alumno->grupos
      ->where('tipo', 'teoria');

    // Mapear turnos permitidos
    $turnoMap = [
      'A' => ['A', 'C'],
      'B' => ['B', 'D'],
    ];

    // Obtener curso_ids agrupados por turno
    $cursosPorTurno = $teorias->groupBy('turno')->map(function($items){
      return $items->pluck('curso_id');
    });

    // Recoger laboratorios válidos
    $allLabs = collect();

    foreach ($cursosPorTurno as $turnoTeoria => $cursoIds) {
      // Turnos permitidos según turno teórico
      $turnosPermitidos = $turnoMap[$turnoTeoria] ?? [];

      $labs = GrupoCurso::with('curso', 'docente.user')
        ->whereIn('curso_id', $cursoIds)
        ->where('tipo', 'laboratorio')
        ->whereIn('turno', $turnosPermitidos)
        ->whereNotIn('id', $gruposAlumno)
        ->get();

      $allLabs = $allLabs->merge($labs);
    }

    return $allLabs->map(fn ($lab) => [
      'id' => $lab->id,
      'nombre' => $lab->curso->nombre,
      'turno' => $lab->turno,
      'docente' => $lab->docente->user->name,
    ]);
  }

  public function matricular($user_id, $grupo_id) {
    $alumno = Alumno::where('user_id', $user_id)->firstOrFail();

    \App\Infrastructure\Shared\Model\Matricula::create([
      'alumno_id' => $alumno->id,
      'grupo_curso_id' => $grupo_id,
    ]);
  }

  public function getLaboratorios($id) {
    $alumno = Alumno::with([
      'grupos.curso',
      'grupos.docente.user'
    ])
      ->where('user_id', $id)
      ->firstOrFail();

    return $alumno->grupos
      ->where('tipo', 'laboratorio')
      ->map(fn ($grupo) => [
        'id' => $grupo->id,
        'nombre' => $grupo->curso->nombre,
        'docente' => $grupo->docente->user->name,
        'turno' => $grupo->turno
      ])
      ->values();
  }
}
