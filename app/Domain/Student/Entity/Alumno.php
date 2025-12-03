<?php

namespace App\Domain\Student\Entity;

use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\Id;

class Alumno {
  private array $grupoIds;
  private function __construct(
    private readonly Id $id,
    private readonly string $nombre,
  ) {
  }

  public static function fromPrimitive(
    Id $id,
    string $nombre,
  ): self {
    if(empty($nombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }

    return new self(
      id: $id,
      nombre: $nombre,
    );
  }

  public function addGrupoId($id): void {
    $this->grupoIds[] = $id;
  }

  public function grupoIds(): array {
    return $this->grupoIds;
  }

  public function nombre(): ?string {
    return $this->nombre;
  }

  public function id(): Id {
    return $this->id;
  }
}
