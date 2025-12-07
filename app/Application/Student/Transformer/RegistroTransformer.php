<?php

namespace App\Application\Student\Transformer;

use App\Domain\Shared\ValueObject\Registro;

class RegistroTransformer {
  public static function toArray(Registro $registro): array {
    return [
      'parcial' => $registro->parcial()->toArray(),
      'continua' => $registro->parcial()->toArray(),
    ];
  }
}
