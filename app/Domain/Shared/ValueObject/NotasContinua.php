<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class NotasContinua
{
  public function __construct(
    // private readonly int $porcentaje?
    private ?int $unidad1,
    private ?int $unidad2,
    private ?int $unidad3,
  ) {}

  public function setUnidad1(int $unidad1): void {
    $this->validate($unidad1);
    $this->unidad1 = $unidad1;
  }

  public function setUnidad2(int $unidad2): void {
    $this->validate($unidad2);
    $this->unidad2 = $unidad2;
  }

  public function setUnidad3(int $unidad3): void {
    $this->validate($unidad3);
    $this->unidad3 = $unidad3;
  }

  public function toArray(): array {
    return [
      $this->unidad1,
      $this->unidad2,
      $this->unidad3,
    ];
  }

  private function validate(int $value): void {
    if($value <= 0 || $value > 20) {
      throw InvalidValue::invalidNota($value);
    }
  }
}
