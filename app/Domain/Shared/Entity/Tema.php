<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\InvalidValue;

readonly class Tema
{
  private function __construct(
    private string $nombre,
    private int    $orden
  ) {}

  public static function fromPrimitives(
    string $nombre,
    int    $orden
  ) {
    if(empty($nombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }

    if($orden < 0) {
      throw InvalidValue::intNegative($orden);
    }

    return new self($nombre, $orden);
  }

  public function nombre(): string {
    return $this->nombre;
  }

  public function orden(): int {
    return $this->orden;
  }
}
