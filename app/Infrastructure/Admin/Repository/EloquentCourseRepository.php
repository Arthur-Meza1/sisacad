<?php

namespace App\Infrastructure\Admin\Repository;

use App\Application\Admin\DTOs\TemaDTO;
use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Domain\Admin\Repository\ICourseRepository;
use App\Application\Admin\DTOs\CourseDTO;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Curso;

class EloquentCourseRepository implements ICourseRepository
{
  /**
   * @return CourseDTO[]
   */
  public function all(): array
  {
    return Curso::with(['temas', 'grupoCursos'])->get()->map(
      fn(Curso $curso) => new CourseDTO(
        id: Id::fromInt($curso->id),
        nombre: $curso->nombre,

        temasCount: $curso->temas->count(),
        temas: $curso->temas->map(
          fn($tema) => new TemaDTO(
            id: Id::fromInt($tema->id),
            nombre: $tema->titulo
          )
        )->all(),

        grupos: $curso->grupoCursos->map(
          fn($grupo) => new GrupoCursoDTO(
            id: Id::fromInt($grupo->id),
            nombre: $grupo->curso->nombre,
            turno: $grupo->turno,
            tipo: $grupo->tipo,
            nregistros: $grupo->alumnos->count(),
          )
        )->all(),
      )
    )->all();
  }

  /**
   * @return CourseDTO[]
   */
  public function search(string $query): array
  {
    return Curso::query()
      ->where('nombre', 'like', "%{$query}%")
      ->orderBy('nombre')
      ->get()
      ->map(
        fn(Curso $curso) => new CourseDTO(
          id: Id::fromInt($curso->id),
          nombre: $curso->nombre,

          temasCount: $curso->temas->count(),
          temas: $curso->temas->map(
            fn($tema) => new TemaDTO(
              id: Id::fromInt($tema->id),
              nombre: $tema->titulo
            )
          )->all(),

          grupos: $curso->grupoCursos->map(
            fn($grupo) => new GrupoCursoDTO(
              id: Id::fromInt($grupo->id),
              nombre: $grupo->curso->nombre,
              turno: $grupo->turno,
              tipo: $grupo->tipo,
              nregistros: $grupo->alumnos->count(),
            )
          )->all(),
        )
      )->all();
  }
}
