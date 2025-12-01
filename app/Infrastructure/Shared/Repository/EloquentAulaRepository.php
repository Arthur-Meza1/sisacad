<?php

namespace App\Infrastructure\Shared\Repository;

use App\Application\Shared\DTOs\AulaDTO;
use App\Domain\Shared\Repository\IAulaRepository;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Aula;
use App\Infrastructure\Shared\Model\Aula as EloquentAula;
use App\Infrastructure\Shared\Model\BloqueHorario as EloquentBloqueHorario;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;
use Carbon\Carbon;

class EloquentAulaRepository implements IAulaRepository {
  public function getDisponiblesDTOsBetween(Fecha $fecha, Hora $horaInicio, Hora $horaFin): array {
    $aulasOcupadas = EloquentBloqueHorario::where('dia', Dia::GetStringDayFromDayWeek($fecha->getDayOfWeek()))
      ->where('horaInicio', '<', $horaFin->toString())
      ->where('horaFin', '>', $horaInicio->toString())
      ->pluck('aula_id')
      ->merge(
        EloquentSesion::where('fecha', $fecha->toString())
          ->where('horaInicio', '<', $horaFin->toString())
          ->where('horaFin', '>', $horaInicio->toString())
          ->pluck('aula_id')
      )
      ->unique();

    return EloquentAula::whereNotIn('id', $aulasOcupadas)
      ->get()
      ->map(fn (EloquentAula $aula) => new AulaDTO(
        id: Id::fromInt($aula->id),
        nombre: $aula->nombre
      ))->toArray();
  }
}
