<?php

namespace App\Application\Student\UseCase;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;

class GetGruposData {
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
    private readonly IGrupoCursoRepository $grupoCursoRepository,
  ) {}

  public function execute(Id $id): array {

  }
}
