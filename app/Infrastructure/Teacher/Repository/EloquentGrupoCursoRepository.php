<?php

namespace App\Infrastructure\Teacher\Repository;

use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Application\Teacher\DTOs\AlumnoDTO;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;
use App\Infrastructure\Shared\Model\Matricula as EloquentMatricula;
use App\Infrastructure\Shared\Parser\ParseGrupoCursoToDomain;

class EloquentGrupoCursoRepository implements IGrupoCursoRepository
{
    public function findOrFail(Id $id): GrupoCurso
    {
      $eloquentGrupoCurso =
        EloquentGrupoCurso::with('curso')
          ->findOrFail($id->getValue());

      return ParseGrupoCursoToDomain::fromEloquent($eloquentGrupoCurso);
    }

  /**
     * @param  Id[]  $ids
     */
    public function findQueryFromIds(array $ids): array
    {
        return EloquentGrupoCurso::with(['curso'])
            ->withCount('alumnos')
            ->whereIn('id', $ids)
            ->get()
            ->map(function (EloquentGrupoCurso $grupo) {
                return new GrupoCursoDTO(
                    id: Id::fromInt($grupo->id),
                    cursoId: Id::fromInt($grupo->curso->id),
                    nombre: $grupo->curso->nombre,
                    turno: $grupo->turno,
                    tipo: $grupo->tipo,
                    nregistros: $grupo->alumnos_count,
                );
            })->toArray();
    }

    public function getAlumnosFromId(Id $id): array
    {
        return EloquentMatricula::with(['alumno.user'])
            ->where('grupo_curso_id', $id->getValue())
            ->get()
            ->map(fn (EloquentMatricula $matricula) => new AlumnoDTO(
                id: $matricula->alumno->id,
                nombre: $matricula->alumno->user->name,
            ))->toArray();
    }
}
