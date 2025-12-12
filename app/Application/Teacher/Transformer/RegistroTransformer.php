<?php

namespace App\Application\Teacher\Transformer;

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
        "id" => $alumno->id()->getValue(),
        "nombre" => $alumno->nombre(),
        "parcial" => $alumno->registro()->parcial()->toArray(),
        "sustitutorio" => $alumno->registro()->parcial()->sustitutorio(),
        "continua" => $alumno->registro()->continua()->toArray()
      ];
    }

    return $res;
  }
}
