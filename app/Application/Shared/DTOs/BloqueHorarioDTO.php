<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;

readonly class BloqueHorarioDTO
{
    public function __construct(
        public Id $id,
        public Fecha|Dia $fechaOrDia,
        public Hora $horaInicio,
        public Hora $horaFin,
        public Id $grupoId,
        public string $grupoNombre,
        public CursoTipo $tipo,
        public GrupoTurno $turno,
        public Id $aulaId,
        public string $aulaNombre,
    ) {}
}
