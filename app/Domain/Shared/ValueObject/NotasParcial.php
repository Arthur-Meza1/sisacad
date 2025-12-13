<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class NotasParcial
{
  public function __construct(
    // private readonly int $porcentaje?
    private ?int $unidad1,
    private ?int $unidad2,
    private ?int $unidad3,
    private ?int $sustitutorio,
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

  public function setSustitutorio(int $sustitutorio): void {
    $this->validate($sustitutorio);
    $this->sustitutorio = $sustitutorio;
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

  public function sustitutorio(): ?int {
    return $this->sustitutorio;
  }

  public function toArray(): array {
    return [$this->unidad1, $this->unidad2, $this->unidad3];
  }

  private function validate(int $value): void {
    if($value <= 0 || $value > 20) {
      throw InvalidValue::invalidNota($value);
    }
  }
}
