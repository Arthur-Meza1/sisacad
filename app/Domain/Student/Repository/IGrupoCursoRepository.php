<?php

namespace App\Domain\Student\Repository;


use App\Application\Student\DTOs\GrupoCursoDTO;
use App\Domain\Shared\ValueObject\Id;

interface IGrupoCursoRepository
{
  /**
   * @param int[] $ids
   * @return GrupoCursoDTO[]
   */
  public function findQueryFromIds(array $ids): array;

}
