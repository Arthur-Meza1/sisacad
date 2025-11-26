<?php

namespace App\Services;

use App\Infrastructure\Shared\Model\Aula;
use App\Infrastructure\Shared\Model\BloqueHorario;
use App\Infrastructure\Shared\Model\Sesion;
use Carbon\Carbon;

class AulaService {
  public function getAvailableList($fecha, $horaInicio, $horaFin) {
    $date = Carbon::parse($fecha);

    $diasSemana = [
      1 => 'lunes',
      2 => 'martes',
      3 => 'miercoles',
      4 => 'jueves',
      5 => 'viernes'
    ];

    $aulasOcupadas = BloqueHorario::where('dia', $diasSemana[$date->dayOfWeek])
      ->where('horaInicio', '<', $horaFin)
      ->where('horaFin', '>', $horaInicio)
      ->pluck('aula_id')
      ->merge(
        Sesion::where('fecha', $date->format('Y-m-d'))
          ->where('horaInicio', '<', $horaFin)
          ->where('horaFin', '>', $horaInicio)
          ->pluck('aula_id')
      )
      ->unique();

    return Aula::whereNotIn('id', $aulasOcupadas)->get();
  }
}
