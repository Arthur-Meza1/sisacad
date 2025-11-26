<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;
use Carbon\Carbon;

class Hora
{
  private function __construct(
    private readonly string $hora,
  )
  {
    $formatosValidos = ['H:i', 'H:i:s'];

    $esValida = collect($formatosValidos)
      ->contains(fn ($formato) => Carbon::canBeCreatedFromFormat($this->hora, $formato));

    if (!$esValida) {
      throw InvalidValue::invalidHour($this->hora);
    }
  }

  /**
   * @param string $hora
   * @return self
   * @throws InvalidValue
   */
  public static function fromString(string $hora): self {
    return new self($hora);
  }

  public function getValue(): string {
    return $this->hora;
  }
}
