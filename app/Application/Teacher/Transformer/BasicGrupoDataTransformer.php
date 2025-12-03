<?php

namespace App\Application\Teacher\Transformer;

use App\Application\Teacher\DTOs\GrupoCursoDTO;

class BasicGrupoDataTransformer {
  /**
   * @param array $dtos
   * @return GrupoCursoDTO[]
   */
  public static function toArray(array $dtos): array {
    $res = [];

    foreach ($dtos as $dto) {
      $res[] = [
        "id" => $dto->id->getValue(),
        "nombre" => $dto->nombre,
        "turno" => $dto->turno,
        "tipo" => $dto->tipo,
        "cantidad" => $dto->nregistros,
      ];
    }

    return $res;
  }
}
