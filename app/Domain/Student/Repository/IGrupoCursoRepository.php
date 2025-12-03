<?php

namespace App\Domain\Student\Repository;


use App\Application\Student\DTOs\GrupoCursoDTO;

interface IGrupoCursoRepository
{
  /**
   * @param array $ids
   * @return GrupoCursoDTO[]
   */
  public function findQueryFromIds(array $ids): array;

}
