<?php

namespace App\Domain\Shared\Exception;

class InvalidValue extends \Exception
{
    public static function intNegative(int $val): self
    {
        return new self("Int negativo: '{$val}'");
    }

    public static function stringNullOrEmpty(): self
    {
        return new self('String null or empty:');
    }

    public static function invalidDate(string $fecha): self
    {
        return new self("Fecha invalida '{$fecha}'");
    }

    public static function invalidHour(string $hour): self
    {
        return new self("Hora invalida '{$hour}'");
    }

    public static function invalidBoolString(string $bool): self
    {
        return new self("Bool string invalido '{$bool}'");
    }

    public static function invalidNota(int $value): self
    {
        return new self("Nota invalida '{$value}'");
    }
}
