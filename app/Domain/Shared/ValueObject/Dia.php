<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidDia;

class Dia {
  public const LUNES = "lunes";
  public const MARTES = "martes";
  public const MIERCOLES = "miercoles";
  public const JUEVES = "jueves";
  public const VIERNES = "viernes";

  private function __construct(
    private readonly string $dia
  ) {
    if(!in_array($dia, self::allowedDia())) {
      throw InvalidDia::execute($dia);
    }
  }

  /**
   * @param string $dia
   * @return self
   * @throws InvalidDia
   */
  public static function fromString(string $dia): self {
    return new self($dia);
  }

  public function getValue(): string {
    return $this->dia;
  }

  public function getDay(): int {
    $map = [
      Dia::LUNES     => 1,
      Dia::MARTES    => 2,
      Dia::MIERCOLES => 3,
      Dia::JUEVES    => 4,
      Dia::VIERNES   => 5,
    ];

    return $map[$this->dia];
  }

  public static function allowedDia(): array {
    return [self::LUNES, self::MARTES, self::MIERCOLES, self::JUEVES, self::VIERNES];
  }
}
