<?php

namespace App\Domain\Shared\Exception;

use App\Domain\Shared\ValueObject\Id;

class RegistroNotFound extends \Exception
{
    public static function execute(Id $id): self
    {
        return new self("Registro {$id->getValue()} no encontrado");
    }
}
