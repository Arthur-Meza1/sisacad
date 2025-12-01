<?php

namespace App\Domain\Teacher\Repository;

use App\Application\Teacher\DTOs\GrupoCursoDTO;
use App\Domain\Shared\ValueObject\Id;

interface IGrupoCursoRepository {
  /**
   * @param array $ids
   * @return GrupoCursoDTO[]
   */
  public function findQueryFromIds(array $ids): array;
  public function getAlumnosFromId(Id $id): array;
}
