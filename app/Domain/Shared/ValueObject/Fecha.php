<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class Fecha
{
  private function __construct(
    private readonly string $fecha,
  )
  {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
      throw InvalidValue::invalidDate();
    }
  }

  /**
   * @param string $fecha
   * @return self
   * @throws InvalidValue
   */
  public static function fromString(string $fecha): self {
    return new self($fecha);
  }

  public function getDay(): int {
    return \Carbon\Carbon::parse($this->fecha)->dayOfWeekIso;
  }

  public function getValue(): string {
    return $this->fecha;
  }
}
