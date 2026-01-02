<?php

namespace App\Domain\Student\Exception;

use App\Domain\Shared\ValueObject\Id;

class AlumnoNotFound extends \Exception
{
    public static function execute(Id $alumnoId): self
    {
        return new self("Alumno {$alumnoId} no encontrado");
    }
}
