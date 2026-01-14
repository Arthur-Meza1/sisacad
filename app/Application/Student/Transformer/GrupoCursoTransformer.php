<?php

namespace App\Application\Student\Transformer;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\Entity\Tema;
use Illuminate\Support\Collection;

class GrupoCursoTransformer {
  /**
   * @param GrupoCurso[] $cursos
   * @return array
   */
  public static function toArray(array $cursos): array {
    $res = [];

    foreach ($cursos as $curso) {
      $res[] = [
        'id' => $curso->id()->getValue(),
        'nombre' => $curso->curso()->nombre(),
        'temas' => self::temasToArray($curso->temas()),
        'turno' => $curso->grupoTurno()->getValue(),
        'tipo' => $curso->cursoTipo()->getValue(),
        'docente' => $curso->docente()
      ];
    }

    return $res;
  }

  private static function temasToArray(Collection $temas): array {
    return $temas->map(fn (Tema $tema) => [
      'nombre' => $tema->nombre(),
      'orden' => $tema->orden()
    ])->toArray();
  }
}
