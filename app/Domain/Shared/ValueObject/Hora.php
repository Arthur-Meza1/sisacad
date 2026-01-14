<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;
use Carbon\Carbon;

class Hora
{
    private function __construct(
        private readonly Carbon $hora,
    ) {}

    /**
     * @throws InvalidValue
     */
    public static function fromString(string $hora): self
    {
        try {
            return new self(Carbon::parse($hora));
        } catch (\Throwable $th) {
            throw InvalidValue::invalidHour($hora);
        }
    }

    public function toMinutes(): int
    {
        return $this->hora->diffInMinutes();
    }

    public function toCarbon(): Carbon
    {
        return $this->hora;
    }

    public function toString(): string
    {
        return $this->hora->format('H:i');
    }
}
