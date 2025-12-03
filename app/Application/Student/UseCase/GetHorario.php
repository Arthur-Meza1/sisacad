<?php

namespace App\Application\Student\UseCase;

use App\Application\Student\Transformer\HorarioTransformer;
use App\Domain\Shared\Repository\IHorarioRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;

class GetHorario
{
  public function __construct(
    private readonly IAlumnoRepository $alumnoRepository,
    private readonly IHorarioRepository $horarioRepository
  ) {}
  public function execute(Id $id): array {
    $alumno = $this->alumnoRepository->findFromIdOrFail($id);
    $horario = $this->horarioRepository->getFromGrupoIds($alumno->grupoIds(), false);

    return HorarioTransformer::toArray($horario);
  }
}
