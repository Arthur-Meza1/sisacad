<?php

namespace App\Infrastructure\Teacher\Parser;

use App\Domain\Teacher\Entity\Docente;
use App\Infrastructure\Teacher\Model\Docente as EloquentDocente;

class ParseDocenteToDomain {
  public static function fromEloquent(EloquentDocente $eloquentDocente): Docente {
    $value = (object) [
      'id' => $eloquentDocente->id,
      'grupoIds' => $eloquentDocente
        ->grupos
        ->map(fn ($grupo) => $grupo->id)
        ->toArray(),
    ];

    return Docente::fromPrimitive($value);
  }
}
