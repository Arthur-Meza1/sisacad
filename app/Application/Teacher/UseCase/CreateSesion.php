<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Student\Repository\IAlumnoRepository;

class CreateSesion
{
    public function __construct(
        private readonly IAlumnoRepository $alumnoRepository,
        private readonly ISesionRepository $sesionRepository,
    ) {}

    public function execute(SesionDto $dto): void
    {
        $sesion = $this->sesionRepository->create(
            fecha: $dto->fecha,
            inicio: $dto->horaInicio,
            fin: $dto->horaFin,
            grupoId: $dto->grupoId,
            aulaId: $dto->aulaId,
        );

        $alumnos = $this->alumnoRepository->getByGrupoCursoId($dto->grupoId);

        foreach ($alumnos as $alumno) {
            $sesion->registrarAsistencia($alumno->id(), $alumno->nombre(), AsistenciaEstado::fromBoolean(false));
        }

        $this->sesionRepository->update($sesion);
    }
}
