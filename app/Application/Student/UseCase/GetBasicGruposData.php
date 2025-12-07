<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\GrupoCursoTransformer;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;

class GetBasicGruposData {
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
  ) {}

  public function execute(Id $id): array {
    $alumno = $this->alumnoRepository->findFromIdOrFail($id);

    return GrupoCursoTransformer::toArray($alumno->grupos());
  }
}
