<?php

namespace App\Infrastructure\Student\Parser;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;

class ParseAlumnoToDomain {
  public static function fromEloquent(EloquentAlumno $eloquentAlumno): Alumno {
    $alumno = Alumno::fromPrimitive(
      id: Id::fromInt($eloquentAlumno->id),
      nombre: $eloquentAlumno->user->name
    );

    $eloquentAlumno->grupos->each(function ($grupo) use (&$alumno) {
      $alumno->addGrupoId($grupo->id);
    });

    return $alumno;
  }
}
