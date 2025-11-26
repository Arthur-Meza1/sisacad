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
        "tipo" => $dto->tipo,
        "cantidad" => $dto->nregistros,
        "promedio_parcial" => $dto->promedio_parcial,
        "promedio_continua" => $dto->promedio_continua,
      ];
    }

    return $res;
  }
}
