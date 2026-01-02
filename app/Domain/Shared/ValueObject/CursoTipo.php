<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidCursoTipo;

class CursoTipo
{
    public const TEORIA = 'teoria';

    public const LABORATORIO = 'laboratorio';

    private function __construct(
        private readonly string $tipo
    ) {}

    public static function fromString(
        string $tipo
    ): self {
        if (! in_array($tipo, self::allowedTipo())) {
            throw InvalidCursoTipo::execute($tipo);
        }

        return new self($tipo);
    }

    public static function allowedTipo(): array
    {
        return [self::TEORIA, self::LABORATORIO];
    }

    public function getValue(): string
    {
        return $this->tipo;
    }
}
