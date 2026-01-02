<?php

namespace App\Domain\Shared\Exception;

class InvalidCursoTipo extends \Exception
{
    public static function execute(string $tipo): self
    {
        return new self("Invalid CursoTipo: {$tipo}");
    }
}
