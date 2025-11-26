<?php

namespace App\Application\Teacher\DTOs;

use App\Domain\Shared\ValueObject\Id;

class GrupoCursoDTO {
  private function __construct(
    public readonly Id $id,
    public readonly string $nombre,
    public readonly string $tipo,
    public readonly int $nregistros,
    public readonly int $promedio_parcial,
    public readonly int $promedio_continua,
  ) {
  }

  public static function create(
    Id $id,
    string $nombre,
    string $tipo,
    int $nregistros,
    int $promedio_parcial,
    int $promedio_continua,
  ) {
    return new GrupoCursoDTO($id, $nombre, $tipo, $nregistros, $promedio_parcial, $promedio_continua);
  }
}
