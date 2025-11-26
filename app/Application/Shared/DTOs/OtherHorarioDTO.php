<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;

class OtherHorarioDTO {
  public function __construct(
    public readonly Fecha|Dia $fechaOrDia,
    public readonly Hora $horaInicio,
    public readonly Hora $horaFin,
    public readonly string $aula,
    public readonly bool $fromBloque,
  ) {}

  /**
   * Clave única para usar en ->unique()
   */
  public function uniqueKey(): string {
    return "{$this->fechaOrDia->getDay()}|{$this->horaInicio->getValue()}|{$this->horaFin->getValue()}|{$this->aula}";
  }
}
