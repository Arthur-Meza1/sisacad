<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Transformer\RegistroTransformer;
use App\Domain\Shared\Exception\RegistroNotFound;
use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;
use App\Domain\Student\Repository\IAlumnoRepository;

class GetNotas {
  public function __construct(
    private IAlumnoRepository $alumnoRepository,
    private IRegistroRepository $registroRepository
  ) {}

  public function execute(Id $grupoId): array {
    $alumnos = $this->alumnoRepository->getByGrupoCursoId($grupoId);

    foreach ($alumnos as $alumno) {
      $registro = $this->registroRepository->getOrCreateByAlumnoInGrupo($alumno->id(), $grupoId);
      $alumno->loadRegistro($registro);
    }

    return RegistroTransformer::toArray($alumnos);
  }
}
