<?php

namespace App\Application\Student\UseCase;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IAlumnoRepository;

readonly class GetAsistencias
{
    public function __construct(
        private IAlumnoRepository $alumnoRepository,
    ) {}

    public function execute(Id $id): array
    {
        $alumno = $this->alumnoRepository->findFromUserIdOrFail($id);

        return $this->alumnoRepository->getAsistenciasById($alumno->id())->toArray();
    }
}
