<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Id;

class Asistencia
{
    public function __construct(
        private readonly Id $alumnoId,
        private readonly ?string $alumnoNombre,
        private AsistenciaEstado $estado,
    ) {}

    public function updateStatus(AsistenciaEstado $estado): void
    {
        $this->estado = $estado;
    }

    public function alumnoId(): Id
    {
        return $this->alumnoId;
    }

    public function estado(): AsistenciaEstado
    {
        return $this->estado;
    }

    public function alumnoNombre(): ?string
    {
        return $this->alumnoNombre;
    }
}
