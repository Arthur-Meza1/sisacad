<?php

namespace App\Domain\Teacher\Repository;

use App\Application\Shared\DTOs\GrupoCursoDTO;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\Id;

interface IGrupoCursoRepository
{
    public function findOrFail(Id $id): GrupoCurso;
    /**
     * @return GrupoCursoDTO[]
     */
    public function findQueryFromIds(array $ids): array;

    public function getAlumnosFromId(Id $id): array;
}
