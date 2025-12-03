<?php

namespace App\Infrastructure\Teacher\Repository;

use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Application\Teacher\DTOs\AlumnoDTO;
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
        $nregistros = $grupo->registros_count;
        $promedio_parcial = $grupo->registros
          ->flatMap(fn ($registro) => $registro->getNotasParcial())
          ->filter()
          ->avg();
        $promedio_continua = $grupo->registros
          ->flatMap(fn ($registro) => $registro->getNotasContinua())
          ->filter()
          ->avg();

        return new GrupoCursoDTO(
          id: Id::fromInt($grupo->id),
          nombre: $grupo->curso->nombre,
          docente: $grupo->docente->user->name,
          tipo: $grupo->tipo,
          turno: $grupo->turno,
          nregistros: $nregistros,
          promedio_parcial: round($promedio_parcial),
          promedio_continua: round($promedio_continua),
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
