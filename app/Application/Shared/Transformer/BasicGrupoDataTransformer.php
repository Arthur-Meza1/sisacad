<?php

namespace App\Application\Shared\Transformer;

use App\Application\Shared\DTOs\GrupoCursoDTO;

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
        "docente" => $dto->docente,
        "nombre" => $dto->nombre,
        "turno" => $dto->turno,
        "tipo" => $dto->tipo,
        "turno" => $dto->turno,
        "cantidad" => $dto->nregistros,
      ];
    }

    return $res;
  }
}
