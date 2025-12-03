<?php

namespace App\Infrastructure\Teacher\Repository;

use App\Application\Teacher\DTOs\AlumnoDTO;
use App\Application\Teacher\DTOs\GrupoCursoDTO;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;
use App\Infrastructure\Shared\Model\Matricula as EloquentMatricula;

class EloquentGrupoCursoRepository implements IGrupoCursoRepository
{
  /**
   * @param Id[] $ids
   * @return array
   */
  public function findQueryFromIds(array $ids): array
  {
    return EloquentGrupoCurso::with(['registros', 'curso', 'docente.user'])
      ->withCount('registros')
      ->whereIn('id', $ids)
      ->get()
      ->map(function (EloquentGrupoCurso $grupo) {
        return new GrupoCursoDTO(
          id: Id::fromInt($grupo->id),
          nombre: $grupo->curso->nombre,
          turno: $grupo->turno,
          tipo: $grupo->tipo,
          nregistros: $grupo->registros_count,
        );
      })->toArray();
  }

  public function getAlumnosFromId(Id $id): array {
    return EloquentMatricula::with(['alumno.user'])
      ->where('grupo_curso_id', $id->getValue())
      ->get()
      ->map(fn (EloquentMatricula $matricula) =>
        new AlumnoDTO(
          id: $matricula->alumno->id,
          nombre: $matricula->alumno->user->name,
        ))->toArray();
  }
}
