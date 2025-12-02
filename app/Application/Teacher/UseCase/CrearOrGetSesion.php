<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Shared\DTOs\SesionDTO;
use App\Application\Teacher\Transformer\SesionTransformer;
use App\Domain\Shared\Exception\SesionNotFound;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Student\Repository\IAlumnoRepository;

class CrearOrGetSesion {
  public function __construct(
    private readonly ISesionRepository $sesionRepository,
    private readonly IAlumnoRepository $alumnoRepository,
  ) {}

    public function execute(SesionDTO $dto): array {
      try {
        $sesion =
          $this->sesionRepository->findByQueryOrFail(
            fecha: $dto->fecha,
            inicio: $dto->horaInicio,
            fin: $dto->horaFin,
            grupoId: $dto->grupoId,
            aulaId: $dto->aulaId,
          );

        return [
          'created' => false,
          'sesion' => SesionTransformer::toArray($sesion),
        ];
      } catch(SesionNotFound) {
        $sesion = $this->sesionRepository->create(
          fecha: $dto->fecha,
          inicio: $dto->horaInicio,
          fin: $dto->horaFin,
          grupoId: $dto->grupoId,
          aulaId: $dto->aulaId,
        );

        $alumnos = $this->alumnoRepository->getByGrupoCursoId($dto->grupoId);

        foreach($alumnos as $alumno) {
          $sesion->registrarAsistencia($alumno->id(), $alumno->nombre(), AsistenciaEstado::fromBoolean(false));
        }

        $this->sesionRepository->update($sesion);

        return [
          'created' => true,
          'sesion' => SesionTransformer::toArray($sesion),
        ];
      }
    }
}
