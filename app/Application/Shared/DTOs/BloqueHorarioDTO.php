<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;

class BloqueHorarioDTO {
  public function __construct(
    public readonly Fecha|Dia $fechaOrDia,
    public readonly Hora $horaInicio,
    public readonly Hora $horaFin,
    public readonly Id $grupoId,
    public readonly string $grupoNombre,
    public readonly CursoTipo $tipo,
    public readonly GrupoTurno $turno,
    public readonly Id $aulaId,
    public readonly string $aulaNombre,
  ) {}
}
