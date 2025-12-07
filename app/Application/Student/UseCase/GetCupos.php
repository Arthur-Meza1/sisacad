<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\BasicGrupoDataTransformer;
use App\Application\Student\Transformer\GrupoCursoTransformer;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\IGrupoCursoRepository;

class GetCupos {
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
    private readonly IGrupoCursoRepository $grupoCursoRepository,
  ) {}
  public function execute(Id $alumnoId): array {
    $alumno = $this->alumnoRepository->findFromIdOrFail($alumnoId);

    $cursos = $alumno->filterGruposByTipo(CursoTipo::TEORIA);
    $gruposId = $alumno->gruposId();

    $labs = [];
    foreach ($cursos as $curso) {
      $labs = [...$labs, ...$this->grupoCursoRepository->getAvailableLabsFromCurso($curso, $gruposId)];
    }

    return BasicGrupoDataTransformer::toArray($labs);
  }
}
