<?php

namespace App\Infrastructure\Student\Repository;

use App\Application\Student\DTOs\GrupoCursoDTO;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Student\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;

class EloquentGrupoCursoRepository implements IGrupoCursoRepository
{
  /**
   * @inheritDoc
   */
  public function findQueryFromIds(array $ids): array
  {
    return EloquentGrupoCurso::with('curso', 'docente.user')
      ->whereIn('id', $ids)
      ->get()
      ->map(function (EloquentGrupoCurso $grupo) {
        return new GrupoCursoDTO(
          nombre: $grupo->curso->nombre,
          docente: $grupo->docente->user->name,
          turno: $grupo->turno,
          tipo: $grupo->tipo,
        );
      })->toArray();
  }

  public function getAvailableLabsFromCurso(GrupoCurso $curso, array $except): array {
    return EloquentGrupoCurso::with('curso', 'docente.user')
      ->where('curso_id', $curso->curso()->id()->getValue())
      ->where("tipo", "laboratorio")
      ->whereIn("turno", $curso->grupoTurno()->getAllowed())
      ->whereNotIn("id", $except)
      ->get()
      ->map(function (EloquentGrupoCurso $grupo) {
        return new GrupoCursoDTO(
          nombre: $grupo->curso->nombre,
          docente: $grupo->docente->user->name,
          turno: $grupo->turno,
          tipo: $grupo->tipo,
        );
      })->toArray();
  }
}
