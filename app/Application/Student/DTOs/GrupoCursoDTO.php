<?php

namespace App\Application\Student\DTOs;

readonly class GrupoCursoDTO {
  public function __construct(
    public string $nombre,
    public string $docente,
    public string $turno,
    public string $tipo,
  ) {
  }
}
