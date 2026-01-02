<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\SesionCerrada;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Carbon\Carbon;

class Sesion
{
    private static int $AVAILABLE_MINUTES = 15;

    private function __construct(
        private readonly Id $id,
        private readonly Fecha $fecha,
        private readonly Hora $horaInicio,
        /** @var Asistencia[] */
        private array $asistencias,
        private bool $cerrada
    ) {}

    public static function fromPrimitives(
        Id $id,
        Fecha $fecha,
        Hora $horaInicio,
    ): self {
        return new self(
            id: $id,
            fecha: $fecha,
            horaInicio: $horaInicio,
            asistencias: [],
            cerrada: false,
        );
    }

    public function registrarAsistencia(Id $alumnoId, ?string $nombre, AsistenciaEstado $estado): void
    {
        if ($this->cerrada) {
            throw SesionCerrada::execute($this->id);
        }

        if (! isset($this->asistencias[$alumnoId->getValue()])) {
            $this->asistencias[$alumnoId->getValue()] =
              new Asistencia($alumnoId, $nombre, $estado);
        } else {
            $this->asistencias[$alumnoId->getValue()]->updateStatus($estado);
        }
    }

    public function editable(): bool
    {
        $target = Carbon::parse("{$this->fecha->toString()} {$this->horaInicio->toString()}");
        $minutes = $target->diffInMinutes(Carbon::now(), false);

        return $minutes >= 0 && $minutes <= self::$AVAILABLE_MINUTES;
    }

    public function id(): Id
    {
        return $this->id;
    }

    /**
     * @return Asistencia[]
     */
    public function asistencias(): array
    {
        return $this->asistencias;
    }
}
