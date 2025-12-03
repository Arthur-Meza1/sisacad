<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\Id;

class GrupoCursoDTO {
  public function __construct(
    public readonly Id $id,
    public readonly string $nombre,
    public readonly string $docente,
    public readonly string $tipo,
    public readonly string $turno,
    public readonly int $nregistros,
    public readonly int $promedio_parcial,
    public readonly int $promedio_continua,
  ) {
  }
}
