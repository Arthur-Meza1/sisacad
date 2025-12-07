<?php

namespace App\Domain\Student\Entity;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\NotasContinua;
use App\Domain\Shared\ValueObject\NotasParcial;
use App\Domain\Shared\ValueObject\Registro;

class Alumno {
  /** @var GrupoCurso[] */
  private array $grupos;
  private Registro $registro;

  private function __construct(
    private readonly Id $id,
    private readonly string $nombre,
  ) {
  }

  public static function fromPrimitive(
    Id $id,
    string $nombre,
  ): self {
    if(empty($nombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }

    return new self(
      id: $id,
      nombre: $nombre,
    );
  }

  public function addGrupo(GrupoCurso $grupoCurso): void {
    $this->grupos[] = $grupoCurso;
  }

  public function grupos(): array {
    return $this->grupos;
  }

  /**
   * @param string $tipo
   * @return GrupoCurso[]
   */
  public function filterGruposByTipo(string $tipo): array {
    return array_filter($this->grupos,
      function (GrupoCurso $grupoCurso) use ($tipo) {
        return $grupoCurso->cursoTipo()->getValue() === $tipo;
      });
  }

  public function gruposId(): array {
    return array_map(
      fn($grupo) => $grupo->id()->getValue(), $this->grupos()
    );
  }

  public function loadRegistro(Registro $registro): void {
    $this->registro = $registro;
  }

  public function registro(): Registro {
    return $this->registro;
  }

  public function nombre(): ?string {
    return $this->nombre;
  }

  public function id(): Id {
    return $this->id;
  }
}
