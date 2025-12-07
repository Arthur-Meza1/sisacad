<?php

namespace App\Infrastructure\Student\Parser;

use App\Domain\Shared\Entity\Curso;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;

class ParseAlumnoToDomain {
  public static function fromEloquent(EloquentAlumno $eloquentAlumno, bool $loadGrupos): Alumno {
    $alumno = Alumno::fromPrimitive(
      id: Id::fromInt($eloquentAlumno->id),
      nombre: $eloquentAlumno->user->name
    );

    if($loadGrupos) {
      $eloquentAlumno->grupos->each(function ($grupo) use (&$alumno) {
        $alumno->addGrupo(GrupoCurso::fromPrimitive(
          id:  Id::fromInt($grupo->id),
          curso: Curso::create(Id::fromInt($grupo->curso->id), $grupo->curso->nombre),
          grupoTurno: GrupoTurno::fromString($grupo->turno),
          cursoTipo: CursoTipo::fromString($grupo->tipo),
          docenteNombre: $grupo->docente->user->name
        ));
      });
    }

    return $alumno;
  }
}
