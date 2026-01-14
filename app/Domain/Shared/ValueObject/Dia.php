<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidDia;
use Carbon\Carbon;

class Dia
{
    public const LUNES = 'lunes';

    public const MARTES = 'martes';

    public const MIERCOLES = 'miercoles';

    public const JUEVES = 'jueves';

    public const VIERNES = 'viernes';

    private function __construct(
        private readonly string $dia
    ) {
        if (! in_array($dia, self::allowedDia())) {
            throw InvalidDia::execute($dia);
        }
    }

    /**
     * @throws InvalidDia
     */
    public static function fromString(string $dia): self
    {
        return new self($dia);
    }

    public function toString(): string
    {
        return $this->dia;
    }

    public function getDayOfWeek(): int
    {
        $map = [
            Dia::LUNES => 1,
            Dia::MARTES => 2,
            Dia::MIERCOLES => 3,
            Dia::JUEVES => 4,
            Dia::VIERNES => 5,
        ];

        return $map[$this->dia];
    }

    public function equals(Dia $dia): bool
    {
        return $this->toString() === $dia->toString();
    }

    // PROBAR ESTO
    public function toCarbonWithDate(Carbon $date): Carbon
    {
        $targetDayOfWeek = $this->getDayOfWeek();
        $currentDayOfWeek = $date->dayOfWeek;

        $dayDifference = $targetDayOfWeek - $currentDayOfWeek;

        $res = $date->copy();
        $res->addDays($dayDifference);

        return $res;
    }

    public static function allowedDia(): array
    {
        return [self::LUNES, self::MARTES, self::MIERCOLES, self::JUEVES, self::VIERNES];
    }

    public static function GetStringDayFromDayWeek(int $day): string
    {
        $map = [
            1 => Dia::LUNES,
            2 => Dia::MARTES,
            3 => Dia::MIERCOLES,
            4 => Dia::JUEVES,
            5 => Dia::VIERNES,
        ];

        return $map[$day] ?? '';
    }
}
