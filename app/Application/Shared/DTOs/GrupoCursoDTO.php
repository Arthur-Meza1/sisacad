<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\Id;

readonly class GrupoCursoDTO {
  public function __construct(
    public Id     $id,
    public Id     $cursoId,
    public string $nombre,
    public string $turno,
    public string $tipo,
    public int    $nregistros,
  ) {
  }
}
