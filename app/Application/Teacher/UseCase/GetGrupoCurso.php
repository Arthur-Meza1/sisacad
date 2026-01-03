<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;

readonly class GetGrupoCurso
{
  public function __construct(
    private IGrupoCursoRepository $grupoCursoRepository
  ) {}
  public function execute(Id $grupoId): GrupoCurso {
    return $this->grupoCursoRepository->findOrFail($grupoId);
  }
}
