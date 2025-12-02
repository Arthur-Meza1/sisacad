<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\SesionCerrada;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Id;

class Sesion {
  private function __construct(
    private readonly Id $id,
    /** @var Asistencia[] */
    private array $asistencias,
    private bool $cerrada
  ) {}

  public static function fromPrimitives(Id $id): self {
      return new self(
      id: $id,
      asistencias: [],
      cerrada: false,
    );
  }

  public function registrarAsistencia(Id $alumnoId, ?string $nombre, AsistenciaEstado $estado): void {
    if($this->cerrada) {
      throw SesionCerrada::execute($this->id);
    }

    if(!isset($this->asistencias[$alumnoId->getValue()])) {
      $this->asistencias[$alumnoId->getValue()] =
        new Asistencia($alumnoId, $nombre, $estado);
    } else {
      $this->asistencias[$alumnoId->getValue()]->updateStatus($estado);
    }
  }

  public function id(): Id {
    return $this->id;
  }

  /**
   * @return Asistencia[]
   */
  public function asistencias(): array {
    return $this->asistencias;
  }
}
