<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;

class GrupoCurso {
  private array $horariosId = [];
  private function __construct(
    private Id $id,
    private readonly GrupoTurno $turno,
    private readonly Id $docenteId,
    private readonly CursoTipo $tipo,
    private readonly Id $cursoId,
  ) {}
}
