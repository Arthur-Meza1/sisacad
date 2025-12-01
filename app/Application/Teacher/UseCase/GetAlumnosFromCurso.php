<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;

class GetAlumnosFromCurso {
  public function __construct(
    private readonly IGrupoCursoRepository $grupoCursoRepository
  ) {}
  public function execute(Id $id) {
    return $this->grupoCursoRepository->getAlumnosFromId($id);
  }
}
