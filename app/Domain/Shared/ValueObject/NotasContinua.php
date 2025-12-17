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

  public function setUnidad1(?int $unidad1): void {
    $this->unidad1 = $unidad1;
  }

  public function setUnidad2(?int $unidad2): void {
    $this->unidad2 = $unidad2;
  }

  public function setUnidad3(?int $unidad3): void {
    $this->unidad3 = $unidad3;
  }

  public function unidad1(): ?int {
    return $this->unidad1;
  }

  public function unidad2(): ?int {
    return $this->unidad2;
  }

  public function unidad3(): ?int {
    return $this->unidad3;
  }

  public function toArray(): array {
    return [
      $this->unidad1,
      $this->unidad2,
      $this->unidad3,
    ];
  }
}
