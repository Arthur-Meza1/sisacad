<?php

namespace App\Infrastructure\Student\Parser;

use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;

class ParseAlumnoToDomain {
  public static function fromEloquent(EloquentAlumno $eloquentAlumno): Alumno {
    $value = (object) [
      'id' => $eloquentAlumno->id,
      'grupoIds' => $eloquentAlumno
        ->grupos
        ->map(fn ($grupo) => $grupo->id)
        ->toArray(),
    ];

    return Alumno::fromPrimitive($value);
  }
}
