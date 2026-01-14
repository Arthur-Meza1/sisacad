<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetGrupoCurso;
use App\Application\Teacher\UseCase\GetNotas;
use App\Domain\Shared\ValueObject\Id;

readonly class LibretaEditorController
{
  public function __construct(
    private GetGrupoCurso $getGrupoCurso,
    private GetNotas $getNotas
  ) {}
  public function __invoke(int $grupoId) {
    $id = Id::fromInt($grupoId);
    $grupo = $this->getGrupoCurso->execute($id);
    $registros = $this->getNotas->execute($id);
    return view('teacher.libreta.editor', compact('grupo', 'registros'));
  }
}
