<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\Id;

class Curso {
  private function __construct(
    private readonly Id $id,
    private readonly string $nombre,
  ) {}

  public static function create(
    Id $id,
    string $nombre
  ): self {
    if(empty($nombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }

    return new self($id, $nombre);
  }

  public function nombre(): string {
    return $this->nombre;
  }

  public function id(): Id {
    return $this->id;
  }
}
