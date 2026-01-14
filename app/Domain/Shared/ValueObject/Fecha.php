<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class Fecha
{
    private function __construct(
        private readonly Carbon $fecha,
    ) {}

    /**
     * @throws InvalidValue
     */
    public static function fromString(string $fecha): self
    {
        try {
            return new self(Carbon::parse($fecha));
        } catch (InvalidFormatException $e) {
            throw InvalidValue::invalidDate($fecha);
        }
    }

    public function toString(): string
    {
        return $this->fecha->format('Y-m-d');
    }

    public function getDayOfWeek(): int
    {
        return $this->fecha->dayOfWeek;
    }

    public function toCarbon(): Carbon
    {
        return $this->fecha;
    }
}
