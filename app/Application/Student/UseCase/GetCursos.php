<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\GrupoCursoTransformer;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\ICursoRepository;

class GetCursos {
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
  ) {}
  public function execute(Id $userId): array {
    $alumno = $this->alumnoRepository->findFromUserIdOrFail($userId);

    $cursos = $alumno->filterGruposByTipo(CursoTipo::TEORIA);

    return GrupoCursoTransformer::toArray($cursos);
  }
}
