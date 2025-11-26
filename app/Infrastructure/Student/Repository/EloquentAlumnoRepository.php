<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Shared\Exception\UserNotFound;
use App\Infrastructure\Student\Parser\ParseAlumnoToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentAlumnoRepository implements IAlumnoRepository {
  public function findFromIdOrFail(Id $id): Alumno {
    try {
      $alumno = EloquentAlumno::with('grupos')
        ->where('user_id', $id->getValue())->firstOrFail();

      return ParseAlumnoToDomain::fromEloquent($alumno);
    } catch(ModelNotFoundException $e) {
      throw UserNotFound::execute();
    }
  }
}
