<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;
use App\Domain\Student\Exception\AlumnoNotFound;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Infrastructure\Student\Parser\ParseRegistroToDomain;
use App\Infrastructure\Shared\Model\Registro as EloquentRegistro;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRegistroRepository implements IRegistroRepository {
  public function getOrCreateByAlumnoInGrupo(Id $alumnoId, Id $grupoId): Registro {
    try {
      $eloquentAlumno = EloquentAlumno::findOrFail($alumnoId->getValue());

      $eloquentRegistro =
        $eloquentAlumno
          ->registros()
          ->where('grupo_curso_id', $grupoId->getValue())
          ->first();

      if(!$eloquentRegistro) {
        $eloquentRegistro = $eloquentAlumno->registros()->create([
          'grupo_curso_id' => $grupoId->getValue(),
        ]);
      }

      return ParseRegistroToDomain::fromEloquent($eloquentRegistro);
    } catch(ModelNotFoundException) {
      throw AlumnoNotFound::execute($alumnoId);
    }
  }
}
