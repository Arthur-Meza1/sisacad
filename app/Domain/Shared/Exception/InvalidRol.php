<?php

namespace App\Domain\Shared\Exception;

class InvalidRol extends \Exception
{
    public static function execute(string $rol): self
    {
        return new self("Rol invalido: {$rol}");
    }
}
