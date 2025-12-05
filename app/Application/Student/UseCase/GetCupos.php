<?php

namespace App\Application\Student\UseCase;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\IGrupoCursoRepository;

class GetCupos {
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
  ) {}
  public function execute(Id $alumnoId): array {
    $alumno = $this->alumnoRepository->findFromIdOrFail($alumnoId);


    return [];
  }
}
