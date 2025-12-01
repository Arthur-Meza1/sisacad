<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;

class SesionDTO {
  public function __construct(
    public readonly Fecha $fecha,
    public readonly Hora $horaInicio,
    public readonly Hora $horaFin,
    public readonly Id $grupoId,
    public readonly Id $aulaId,
  ) {}
}
