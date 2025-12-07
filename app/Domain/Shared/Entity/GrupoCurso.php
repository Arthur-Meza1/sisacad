<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;

readonly class GrupoCurso {
  private function __construct(
    private Id         $id,
    private Curso      $curso,
    private GrupoTurno $grupoTurno,
    private CursoTipo  $cursoTipo,
    private string     $docenteNombre,
  ) {}

  public static function fromPrimitive(
    Id $id,
    Curso $curso,
    GrupoTurno $grupoTurno,
    CursoTipo $cursoTipo,
    string $docenteNombre,
  ): self {
    if(empty($docenteNombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }
    return new self($id, $curso, $grupoTurno, $cursoTipo, $docenteNombre);
  }

  public function id(): Id {
    return $this->id;
  }

  public function curso(): Curso {
    return $this->curso;
  }

  public function docente(): string {
    return $this->docenteNombre;
  }

  public function grupoTurno(): GrupoTurno {
    return $this->grupoTurno;
  }

  public function cursoTipo(): CursoTipo {
    return $this->cursoTipo;
  }
}
