<?php

namespace App\Application\Student\DTOs;

class GrupoCursoDTO {
  public function __construct(
    public readonly string $nombre,
    public readonly string $docente,
    public readonly string $turno,
    public readonly string $tipo,
  ) {
  }
}
