<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\CursoTransformer;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\ICursoRepository;

class GetCursos {
  public function __construct(
    private readonly ICursoRepository $cursoRepository
  ) {}
  public function execute(Id $alumnoId): array {
    $cursos = $this->cursoRepository->getCursoTeoriaByAlumnoId($alumnoId);

    return CursoTransformer::toArray($cursos);
  }
}
