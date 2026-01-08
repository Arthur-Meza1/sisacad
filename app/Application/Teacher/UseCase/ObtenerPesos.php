<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Transformer\RegistroTransformer;
use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\ICursoRepository;

readonly class ObtenerPesos
{
  public function __construct(
    private ICursoRepository $cursoRepository
  ) {}

  public function execute(Id $cursoId): array
  {
    return  $this->cursoRepository->getPesos($cursoId);
  }
}
