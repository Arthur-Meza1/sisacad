<?php

namespace App\Application\Student\Transformer;

use App\Domain\Shared\Entity\GrupoCurso;

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
        'nombre' => $curso->nombre(),
        'turno' => $curso->grupoTurno()->getValue(),
        'tipo' => $curso->cursoTipo()->getValue(),
      ];
    }

    return $res;
  }
}
