<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
  use AuthorizesRequests;

  public function index()
  {
    return view('student');
  }

  public function getCursos() {
    $alumno = Auth::user()->alumno;
    $cursos =
      $alumno->grupos()
             ->where('tipo', 'teoria')
             ->with('curso')
             ->get()
             ->map(fn ($grupo) => ['id' => $grupo->id, 'nombre' => $grupo->curso->nombre]);
    return response()->json($cursos);
  }

  public function getNotasCurso(int $curso) {
    $alumno = Auth::user()->alumno;
    $notas = $alumno->registros()
                    ->where('grupo_curso_id', $curso)
                    ->first();

    $parcial1 = $notas['parcial1'];
    $parcial2 = $notas['parcial2'];
    if(($sust = $notas['sustitutorio']) != null) {
      if($parcial1 < $parcial2) {
        $parcial1 = $sust;
      } else {
        $parcial2 = $sust;
      }
    }

    return response()->json([
      'Parcial' => [$parcial1, $parcial2, $notas['parcial3']],
      'Continua' => [$notas['continua1'], $notas['continua2'], $notas['continua3']],
    ]);
  }

  public function getHorario() {
    $alumno = Auth::user()->alumno()->with('grupos.bloqueHorario.aula', 'grupos.curso')->first();

    $res = $alumno->grupos->flatMap(function ($grupo) {
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

    $res = $res->groupBy('dia')->map(function ($dayBlocks) {
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

    return response()->json($res);
  }
}
