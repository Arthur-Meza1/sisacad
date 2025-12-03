<?php

namespace App\Application\Student\Transformer;

use App\Application\Student\DTOs\GrupoCursoDTO;

class BasicGrupoDataTransformer {
  /**
   * @param array $dtos
   * @return GrupoCursoDTO[]
   */
  public static function toArray(array $dtos): array {
    $res = [];

    foreach ($dtos as $dto) {
      $res[] = [
        "nombre" => $dto->nombre,
        "docente" => $dto->docente,
        "tipo" => $dto->tipo,
        "turno" => $dto->turno,
      ];
    }

    return $res;
  }
}
