<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Shared\Model\Matricula as EloquentMatricula;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Shared\Exception\UserNotFound;
use App\Infrastructure\Student\Parser\ParseAlumnoToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentAlumnoRepository implements IAlumnoRepository {
  public function getByGrupoCursoId(Id $id): array {
    return EloquentMatricula::with('alumno.user')
      ->where('grupo_curso_id', $id->getValue())
      ->get()
      ->map(fn (EloquentMatricula $matricula) =>
        Alumno::fromPrimitive(
        id: Id::fromInt($matricula->alumno->id),
        nombre: $matricula->alumno->user->name
      ))->toArray();
  }

  public function findFromIdOrFail(Id $id): Alumno {
    try {
      $eloquentAlumno =
        EloquentAlumno::
        with('user', 'grupos')
        ->where('user_id', $id->getValue())->firstOrFail();

      return ParseAlumnoToDomain::fromEloquent($eloquentAlumno);
    } catch(ModelNotFoundException $e) {
      throw UserNotFound::execute();
    }
  }
}
