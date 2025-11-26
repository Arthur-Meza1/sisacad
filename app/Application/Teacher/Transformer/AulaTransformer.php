<?php


namespace App\Application\Teacher\Transformer;

use App\Application\Teacher\DTOs\GrupoCursoDTO;

class AulaTransformer
{
  public static function toArray(array $dtos): array
  {
    $res = [];

    foreach ($dtos as $dto) {
      $res[] = [
        "id" => $dto->id->getValue(),
        "nombre" => $dto->nombre,
      ];
    }

    return $res;
  }
}

