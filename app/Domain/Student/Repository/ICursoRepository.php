<?php

namespace App\Domain\Student\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Curso;

interface ICursoRepository
{
    /**
     * @return Curso[]
     */
    public function getCursoTeoriaByAlumnoId(Id $alumnoId): array;
}
