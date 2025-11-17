<?php

namespace App\Services;

use App\Models\Alumno;

class AlumnoService {
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
    $alumno =
      Alumno::with('grupos.bloqueHorario.aula', 'grupos.curso')
          ->where('user_id', $id)
          ->firstOrFail();

    $horario = $alumno->grupos->flatMap(function ($grupo) {
      return $grupo->bloqueHorario->map(fn($bloque) => [
        'dia' => $bloque->dia,
        'horaInicio' => $bloque->horaInicio,
        'horaFin' => $bloque->horaFin,
        'nombre' => $grupo->curso->nombre,
        'tipo' => $grupo->tipo,
        'turno' => $grupo->turno,
        'aula' => $bloque->aula->nombre,

      ]);
    })->values();

    return $this->collapseHorario($horario);
  }

  private function collapseHorario($horario) {
    return $horario->groupBy('dia')->map(function ($dayBlocks) {
      $sorted = $dayBlocks->sortBy('horaInicio')->values();

      $merged = [];
      $current = null;

      foreach ($sorted as $block) {
        if ($current === null) {
          $current = $block;
          continue;
        }

        $currentEnd = strtotime($current['horaFin']);
        $nextStart = strtotime($block['horaInicio']);

        $isContinuous = $currentEnd === $nextStart &&
          $current['aula'] === $block['aula'] &&
          $current['nombre'] === $block['nombre'] &&
          $current['tipo'] === $block['tipo'];

        if ($isContinuous) {
          $current['horaFin'] = $block['horaFin'];
        } else {
          $merged[] = $current;
          $current = $block;
        }
      }

      if ($current !== null) {
        $merged[] = $current;
      }

      return collect($merged);
    })->flatten(1)->values();
  }
}
