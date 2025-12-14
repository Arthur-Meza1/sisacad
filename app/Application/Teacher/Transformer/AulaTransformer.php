<?php


namespace App\Application\Teacher\Transformer;

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

