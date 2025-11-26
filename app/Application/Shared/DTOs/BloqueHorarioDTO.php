<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;

class BloqueHorarioDTO {
  public function __construct(
    public readonly Fecha|Dia $fechaOrDia,
    public readonly Hora $horaInicio,
    public readonly Hora $horaFin,
    public readonly string $nombre,
    public readonly CursoTipo $tipo,
    public readonly GrupoTurno $turno,
    public readonly string $aula,
  ) {}
}
