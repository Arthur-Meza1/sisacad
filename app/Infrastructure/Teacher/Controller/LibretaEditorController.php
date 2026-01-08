<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetGrupoCurso;
use App\Application\Teacher\UseCase\GetNotas;
use App\Application\Teacher\UseCase\ObtenerSilabo;
use App\Application\Teacher\UseCase\ObtenerPesos;
use App\Domain\Shared\ValueObject\Id;

readonly class LibretaEditorController
{
  public function __construct(
    private GetGrupoCurso $getGrupoCurso,
    private GetNotas $getNotas,
    private ObtenerSilabo $obtenerSilabo,
    private ObtenerPesos $obtenerPesos
  ) {}
  public function __invoke(int $grupoId) {
    $id = Id::fromInt($grupoId);
    $grupo = $this->getGrupoCurso->execute($id);
    $registros = $this->getNotas->execute($id);
    $silabo = $this->obtenerSilabo->execute($grupo->curso()->id());
    $pesos = $this->obtenerPesos->execute($grupo->curso()->id());
    if($silabo['error'])
      return redirect()->back()->withErrors($silabo['message']);
    return view('teacher.libreta.editor', compact('grupo', 'registros', 'pesos'));
  }
}
