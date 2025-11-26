<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\GrupoTurno;

class Curso {
  private function __construct(
    private readonly CursoName $name,
  ) {}
}
