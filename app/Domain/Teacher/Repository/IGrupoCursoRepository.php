<?php

namespace App\Domain\Teacher\Repository;

use App\Application\Teacher\DTOs\GrupoCursoDTO;

interface IGrupoCursoRepository {
  /**
   * @param array $ids
   * @return GrupoCursoDTO[]
   */
  public function findQueryFromIds(array $ids): array;
}
