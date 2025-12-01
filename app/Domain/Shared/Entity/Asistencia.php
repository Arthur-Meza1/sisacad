<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\Id;

class Asistencia {
  private function __construct(
    public readonly Id $sesionId,
    public readonly Id $alumnoId,
    public readonly string $alumnoNombre,
    private bool $status,
  ) {}

  public static function create(Id $sesionId, Id $alumnoId, string $alumnoNombre, bool $status): self {
    return new self($sesionId, $alumnoId, $alumnoNombre,  $status);
  }

  public function presente(): void {
    $this->status = true;
  }

  public function falta(): void {
    $this->status = false;
  }

  public function isPresente(): bool {
    return $this->status;
  }
}
