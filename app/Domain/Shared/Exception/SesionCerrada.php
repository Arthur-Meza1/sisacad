<?php

namespace App\Domain\Shared\Exception;

use App\Domain\Shared\ValueObject\Id;

class SesionCerrada extends \Exception
{
    public static function execute(Id $id): self
    {
        return new self("Sesión {$id->getValue()} cerrada");
    }
}
