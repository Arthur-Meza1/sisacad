<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\RegistroTransformer;
use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;

class GetNotas {
  public function __construct(
    private IAlumnoRepository $alumnoRepository,
    private IRegistroRepository $registroRepository
  ) {}

  public function execute(Id $userId, Id $grupoId): array {
    $alumno = $this->alumnoRepository->findFromIdOrFail($userId, false);

    $registro = $this->registroRepository->getOrCreateByAlumnoInGrupo($alumno->id(), $grupoId);

    return RegistroTransformer::toArray($registro);
  }
}
