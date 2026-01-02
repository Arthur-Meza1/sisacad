<?php

namespace App\Domain\Student\Repository;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\Id;

interface IGrupoCursoRepository
{
    public function matricularEnGrupo(Id $alumnoId, Id $grupoId): void;

    public function desmatricularEnGrupo(Id $alumnoId, Id $grupoId): void;

    public function getAvailableLabsFromCurso(GrupoCurso $curso, array $except): array;
}
