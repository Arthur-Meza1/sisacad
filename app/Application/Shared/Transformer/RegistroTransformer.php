<?php

namespace App\Application\Shared\Transformer;

use App\Domain\Student\Entity\Alumno;

class RegistroTransformer {
  /**
   * @param Alumno[] $alumnos
   * @return array
   */
  public static function toArray(array $alumnos): array {
    $res = [];

    foreach ($alumnos as $alumno) {
      $res[] = [
        "nombre" => $alumno->nombre(),
        "parcial" => $alumno->registro()->parcial()->toArray(),
        "continua" => $alumno->registro()->continua()->toArray()
      ];
    }

    return $res;
  }
}
