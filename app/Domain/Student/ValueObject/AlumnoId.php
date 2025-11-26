<?php

namespace App\Domain\Domain\ValueObject;

class AlumnoId {
  private function __construct(
    private readonly int $id,
  ) {}

  public static function fromInt(int $id): self {
    return new self($id);
  }

  public function getValue(): int {
    return $this->id;
  }
}
