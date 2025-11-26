<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Transformer\HorarioTransformer;
use App\Domain\Shared\Repository\IHorarioRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IDocenteRepository;

class GetHorario {
  public function __construct(
    private readonly IDocenteRepository $docenteRepository,
    private readonly IHorarioRepository $horarioRepository
  ) {}
  public function execute(Id $id): array {
    $docente = $this->docenteRepository->findFromIdOrFail($id);
    $horario = $this->horarioRepository->getOwnHorarioAndOthers($docente->getGruposId());

    return HorarioTransformer::toArray($horario);
  }
}
