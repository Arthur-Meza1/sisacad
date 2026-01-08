<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\Exception\UserNotFound;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\ICursoRepository;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Infrastructure\Shared\Model\Curso as EloquentCurso;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentCursoRepository implements ICursoRepository
{
  /**
   * {@inheritDoc}
   */
  public function getCursoTeoriaByAlumnoId(Id $alumnoId): array
  {
    try {
      $eloquentAlumno =
        EloquentAlumno::where('user_id', $alumnoId->getValue())
          ->firstOrFail();

      return
        $eloquentAlumno->grupos()
          ->where('tipo', 'teoria')
          ->with('curso')
          ->get()
          ->map(fn($grupo) => new Curso(
            Id::fromInt($grupo->id),
            $grupo->curso->nombre,
          ))->toArray();
    } catch (ModelNotFoundException) {
      throw UserNotFound::execute();
    }
  }

  public function getPesos(Id $cursoId): array
  {
    try {
      $eloquentCurso =
        EloquentCurso::where('id', $cursoId->getValue())
          ->firstOrFail();

      return [
        "p1" => $eloquentCurso->peso_p1,
        "p2" => $eloquentCurso->peso_p2,
        "p3" => $eloquentCurso->peso_p3,
        "c1" => $eloquentCurso->peso_c1,
        "c2" => $eloquentCurso->peso_c2,
        "c3" => $eloquentCurso->peso_c3
      ];
    } catch (ModelNotFoundException) {
      throw UserNotFound::execute();
    }
  }
}
