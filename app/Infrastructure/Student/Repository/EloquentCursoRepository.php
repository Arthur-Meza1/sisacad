<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\Exception\UserNotFound;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Curso;
use App\Domain\Student\Repository\ICursoRepository;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentCursoRepository implements ICursoRepository
{

    /**
     * @inheritDoc
     */
    public function getCursoTeoriaByAlumnoId(Id $alumnoId): array
    {
      try {
        $eloquentAlumno =
          EloquentAlumno::
            where('user_id', $alumnoId->getValue())
            ->firstOrFail();

        return
          $eloquentAlumno->grupos()
            ->where('tipo', 'teoria')
            ->with('curso')
            ->get()
            ->map(fn ($grupo) => new Curso(
              Id::fromInt($grupo->id),
              $grupo->curso->nombre,
            ))->toArray();
      } catch (ModelNotFoundException) {
        throw UserNotFound::execute();
      }
    }
}
