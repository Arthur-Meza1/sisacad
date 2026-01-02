<?php

namespace App\Application\Student\UseCase;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Domain\Student\Repository\IGrupoCursoRepository;

class MatricularLab
{
    public function __construct(
        private readonly IAlumnoRepository $alumnoRepository,
        private readonly IGrupoCursoRepository $grupoCursoRepository,
    ) {}

    public function execute(Id $userId, Id $cursoId)
    {
        $alumno = $this->alumnoRepository->findFromUserIdOrFail($userId, false);
        $this->grupoCursoRepository->matricularEnGrupo($alumno->id(), $cursoId);
    }
}
