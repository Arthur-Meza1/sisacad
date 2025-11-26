<?php

namespace App\Infrastructure\Teacher\Repository;

use App\Application\Teacher\DTOs\GrupoCursoDTO;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;

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

        return GrupoCursoDTO::create(
          id: Id::fromInt($grupo->id),
          nombre: $grupo->curso->nombre,
          tipo: $grupo->tipo,
          nregistros: $nregistros,
          promedio_parcial: round($promedio_parcial),
          promedio_continua: round($promedio_continua),
        );
      })->toArray();
  }
}
