<?php

namespace App\Services;

use App\Models\BloqueHorario;
use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use function PHPSTORM_META\map;

class HorarioService {
  public function get($user_class, $user_id, $withOthers = false) {
    $user =
      $user_class::with('grupos.bloqueHorario.aula', 'grupos.curso')
        ->where('user_id', $user_id)
        ->firstOrFail();

    $ids = $user->grupos->pluck('id');
    $sesiones =
      Sesion::with('grupoCurso.curso', 'aula')
        ->where('from_bloque', false)
        ->whereIn('grupo_curso_id', $ids)
        ->get()
        ->map(fn ($sesion) => [
          'fecha' => $sesion->fecha,
          'horaInicio' => $sesion->horaInicio,
          'horaFin' => $sesion->horaFin,
          'nombre' => $sesion->grupoCurso->curso->nombre,
          'tipo' => $sesion->grupoCurso->tipo,
          'turno' => $sesion->grupoCurso->turno,
          'aula' => $sesion->aula->nombre,
        ]);

    $horario = $user->grupos->flatMap(function ($grupo) {
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

    $res = [
      'horario' => $horario,
      'sesiones' => $sesiones,
    ];

    if($withOthers) {
      $otherEvents =
        BloqueHorario::with('aula')
          ->whereNotIn('grupo_curso_id', $ids)
          ->get()
          ->map(fn ($bloque) => [
            'fecha' => $bloque->dia,
            'horaInicio' => $bloque->horaInicio,
            'horaFin' => $bloque->horaFin,
            'aula' => $bloque->aula->nombre,
            'from_bloque' => true,
          ])->merge(
            Sesion::with('aula')
              ->whereNotIn('grupo_curso_id', $ids)
              ->get()
              ->map(fn ($sesion) => [
                'fecha' => $sesion->fecha,
                'horaInicio' => $sesion->horaInicio,
                'horaFin' => $sesion->horaFin,
                'aula' => $sesion->aula->nombre,
                'from_bloque' => false,
              ])
          )->unique(function ($x) {
            $diasSemana = [
              'lunes'     => 1,
              'martes'    => 2,
              'miercoles' => 3,
              'jueves'    => 4,
              'viernes'   => 5,
            ];

            $day = $x['from_bloque'] ? $diasSemana[$x['fecha']] : Carbon::parse($x['fecha'])->dayOfWeekIso;

            return "{$day}|{$x['horaInicio']}|{$x['horaFin']}|{$x['aula']}";
          })->values();
      $res['others'] = $otherEvents;
    }

    return $res;
  }
}
