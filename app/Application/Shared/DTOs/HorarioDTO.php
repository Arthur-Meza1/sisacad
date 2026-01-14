<?php

namespace App\Application\Shared\DTOs;

class HorarioDTO
{
    /**
     * @param  BloqueHorarioDTO[]  $horario
     * @param  BloqueHorarioDTO[]  $sesiones
     * @param  OccuppiedSlotDTO[]  $occupied
     */
    public function __construct(
        public array $horario,
        public array $sesiones,
        public array $occupied,
    ) {}
}
