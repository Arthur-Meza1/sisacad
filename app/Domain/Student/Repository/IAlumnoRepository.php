<?php

namespace App\Domain\Student\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use Illuminate\Support\Collection;

interface IAlumnoRepository
{
    /**
     * @return Alumno[]
     */
    public function getByGrupoCursoId(Id $id): array;

    public function findFromUserIdOrFail(Id $id, bool $loadGrupos = true): Alumno;

    public function getAsistenciasById(Id $id): Collection;
}
