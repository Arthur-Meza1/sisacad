<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Collection;

class GrupoCurso {
  private function __construct(
    private readonly Id         $id,
    private readonly Curso      $curso,
    private readonly GrupoTurno $grupoTurno,
    private readonly CursoTipo  $cursoTipo,
    private readonly string     $docenteNombre,
    private Collection          $temas,
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
    return new self(
      $id,
      $curso,
      $grupoTurno,
      $cursoTipo,
      $docenteNombre,
      collect());
  }

  public function addTema(Tema $tema): void {
    $this->temas->push($tema);
  }

  public function temas(): Collection {
    return $this->temas;
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
