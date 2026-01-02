<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;

interface IAulaRepository
{
    public function getDisponiblesDTOsBetween(Fecha $fecha, Hora $horaInicio, Hora $horaFin): array;
}
