<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;

class GrupoCurso {
  private function __construct(
    private readonly Id $id,
    private readonly string $nombre,
    private readonly GrupoTurno $grupoTurno,
    private readonly CursoTipo $cursoTipo,
  ) {}

  public static function fromPrimitive(
    Id $id,
    string $nombre,
    GrupoTurno $grupoTurno,
    CursoTipo $cursoTipo,
  ): self {
    return new self($id, $nombre, $grupoTurno, $cursoTipo);
  }

  public function id(): Id {
    return $this->id;
  }

  public function nombre(): string {
    return $this->nombre;
  }

  public function grupoTurno(): GrupoTurno {
    return $this->grupoTurno;
  }

  public function cursoTipo(): CursoTipo {
    return $this->cursoTipo;
  }
}
