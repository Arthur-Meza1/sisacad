<?php

namespace App\Application\Student\Transformer;

use App\Domain\Student\Entity\Curso;

class CursoTransformer {
  /**
   * @param Curso[] $cursos
   * @return array
   */
  public static function toArray(array $cursos): array {
    $res = [];

    foreach ($cursos as $curso) {
      $res[] = [
        'id' => $curso->id()->getValue(),
        'nombre' => $curso->nombre()
      ];
    }

    return $res;
  }
}
