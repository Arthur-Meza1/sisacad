<?php

namespace App\Application\Teacher\Transformer;

use App\Domain\Shared\Entity\Sesion;

class SesionTransformer {
  public static function toArray(Sesion $sesion): array {
    return [
      'id' => $sesion->id->getValue(),
      'grupoId' => $sesion->dto->grupoId->getValue(),
      'aulaId' => $sesion->dto->aulaId->getValue(),
      'asistencias' => self::asistenciaToArray($sesion->asistencias),
    ];
  }

  private static function asistenciaToArray(array $asistencias): array {
    $res = [];

    foreach ($asistencias as $asistencia) {
      $res[] = [
        'sesion_id' => $asistencia->sesionId->getValue(),
        "alumno" => [
          'id' => $asistencia->alumnoId->getValue(),
          'nombre' => $asistencia->alumnoNombre,
        ],
        'presente' => $asistencia->isPresente(),
      ];
    }

    return $res;
  }
}
