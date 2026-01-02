<?php

namespace App\Domain\Teacher\Repository;

use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Domain\Shared\ValueObject\Id;

interface IGrupoCursoRepository
{
    /**
     * @return GrupoCursoDTO[]
     */
    public function findQueryFromIds(array $ids): array;

    public function getAlumnosFromId(Id $id): array;
}
