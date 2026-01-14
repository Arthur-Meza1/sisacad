<?php

namespace App\Domain\Teacher\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Entity\Docente;

interface IDocenteRepository
{
    public function findFromIdOrFail(Id $id): Docente;
}
