<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;

class OccuppiedSlotDTO
{
    public function __construct(
        public readonly Fecha|Dia $fechaOrDia,
        public readonly Hora $horaInicio,
        public readonly Hora $horaFin,
    ) {}
}
