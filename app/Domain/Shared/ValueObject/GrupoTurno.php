<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidTurno;
use App\Domain\Shared\Exception\InvalidValue;

class GrupoTurno {
  public const A = "A";
  public const B = "B";
  public const C = "C";
  public const D = "D";

  private function __construct(
    private readonly string $turno
  ) {
    if(!in_array($turno, self::allowedTurno())) {
      throw InvalidTurno::execute($turno);
    }
  }

  public static function fromString(
    string $turno
  ): self {
    return new self($turno);
  }

  public function getAllowed(): array {
    if($this->turno === self::A || $this->turno === self::C) {
      return [self::A, self::C];
    } else {
      return [self::B, self::D];
    }
  }

  public static function allowedTurno(): array {
    return [self::A, self::B, self::C, self::D];
  }

  public function getValue(): string {
    return $this->turno;
  }
}
