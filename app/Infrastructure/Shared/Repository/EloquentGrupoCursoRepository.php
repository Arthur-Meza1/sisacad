<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;

class EloquentGrupoCursoRepository implements IGrupoCursoRepository {
  public function deepQueryFromIds(array $ids): array {
    $idValues = array_map(fn(Id $id) => $id->value(), $ids);

    $grupos = EloquentGrupoCurso::with([
      'docente.user',    // carga el docente y su usuario
      'curso',
      'bloqueHorario',
    ])
      ->whereIn('id', $idValues)
      ->get();

    return $grupos->map(fn($grupo) => [
      'id' => $grupo->id,
      'turno' => $grupo->turno,
      'tipo' => $grupo->tipo,
      'curso' => [
        'id' => $grupo->curso->id,
        'nombre' => $grupo->curso->nombre,
      ],
      'docente' => [
        'id' => $grupo->docente->id,
        'nombre' => $grupo->docente->user->nombre ?? null,
      ],
      'bloquesHorario' => $grupo->bloqueHorario->map(fn($b) => [
        'id' => $b->id,
        'dia' => $b->dia,
        'hora_inicio' => $b->hora_inicio,
        'hora_fin' => $b->hora_fin,
        'aula' => [
          'id' => $b->aula->id ?? null,
          'nombre' => $b->aula->nombre ?? null,
        ],
      ])->toArray(),
    ])->toArray();
  }
}
