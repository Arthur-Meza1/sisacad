<?php

namespace App\Application\Student\Transformer;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\Entity\Tema;
use Illuminate\Support\Collection;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;

class GrupoCursoTransformer {
  /**
   * @param GrupoCurso[] $cursos
   * @return array
   */
  public static function toArray(array $cursos): array {
    $res = [];

    foreach ($cursos as $curso) {
      $eloquentGrupo = EloquentGrupoCurso::find($curso->id()->getValue());

      $res[] = [
        'id' => $curso->id()->getValue(),
        'nombre' => $curso->curso()->nombre(),
        'temas' => self::temasToArray($curso->temas(), $eloquentGrupo),
        'unidades' => self::unidadesToArray($curso->unidades(), $eloquentGrupo),
        'turno' => $curso->grupoTurno()->getValue(),
        'tipo' => $curso->cursoTipo()->getValue(),
        'docente' => $curso->docente(),
        'progreso' => $eloquentGrupo ? $eloquentGrupo->progreso : 0
      ];
    }

    return $res;
  }

  private static function temasToArray(Collection $temas, ?EloquentGrupoCurso $eloquentGrupo = null): array {
    return $temas->map(function (Tema $tema) use ($eloquentGrupo) {
      $temaId = $tema->id();

      return [
        'id' => $temaId,
        'nombre' => $tema->nombre(),
        'orden' => $tema->orden(),
        'enseñado' => ($temaId && $eloquentGrupo) ? (bool)$eloquentGrupo->temaEstaEnseñado($temaId) : false,
        'fecha_enseñado' => ($temaId && $eloquentGrupo) ? $eloquentGrupo->fechaTemaEnseñado($temaId) : null
      ];
    })->toArray();
  }

  private static function capitulosToArray(Collection $capitulos, ?EloquentGrupoCurso $eloquentGrupo = null): array {
    return $capitulos->map(function ($cap) use ($eloquentGrupo) {
      return [
        'nombre' => $cap['nombre'],
        'temas' => self::temasToArray($cap['temas'], $eloquentGrupo)
      ];
    })->toArray();
  }

  private static function unidadesToArray(Collection $unidades, ?EloquentGrupoCurso $eloquentGrupo = null): array {
    return $unidades->map(function ($u) use ($eloquentGrupo) {
      return [
        'nombre' => $u['nombre'],
        'capitulos' => collect($u['capitulos'])->map(function ($cap) use ($eloquentGrupo) {
          return [
            'nombre' => $cap['nombre'],
            'temas' => self::temasToArray($cap['temas'], $eloquentGrupo)
          ];
        })->toArray()
      ];
    })->toArray();
  }
}
