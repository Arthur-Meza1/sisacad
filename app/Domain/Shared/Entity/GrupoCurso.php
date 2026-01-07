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
    private Collection          $capitulos,
    private Collection          $unidades,
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
      collect(),
      collect(),
      collect());
  }

  public function addTema(Tema $tema): void {
    $this->temas->push($tema);
  }

  public function addCapitulo(string $nombre, Collection $temas): void {
    $this->capitulos->push([
      'nombre' => $nombre,
      'temas' => $temas
    ]);
  }

  public function addUnidad(string $nombre, Collection $capitulos): void {
    $this->unidades->push([
      'nombre' => $nombre,
      'capitulos' => $capitulos
    ]);
  }

  public function temas(): Collection {
    return $this->temas;
  }

  public function capitulos(): Collection {
    return $this->capitulos;
  }

  public function unidades(): Collection {
    return $this->unidades;
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
