<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Application\Teacher\Transformer\BasicGrupoDataTransformer;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IDocenteRepository;
use App\Domain\Teacher\Repository\IGrupoCursoRepository;

class GetBasicGruposData {
  public function __construct(
    private readonly IDocenteRepository $docenteRepository,
    private readonly IGrupoCursoRepository $grupoCursoRepository,
  ) {}

  /**
   * @param Id $id
   * @return GrupoCursoDTO[]
   */
  public function execute(Id $id): array {
    $docente = $this->docenteRepository->findFromIdOrFail($id);
    $dtos = $this->grupoCursoRepository->findQueryFromIds($docente->getGruposId());

    return BasicGrupoDataTransformer::toArray($dtos);
  }
}
