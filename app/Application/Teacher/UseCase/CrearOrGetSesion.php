<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Shared\DTOs\SesionDTO;
use App\Application\Teacher\Transformer\SesionTransformer;
use App\Domain\Shared\Exception\SesionNotFound;
use App\Domain\Shared\Repository\IAsistenciaRepository;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Student\Repository\IAlumnoRepository;

class CrearOrGetSesion {
  public function __construct(
    private readonly ISesionRepository $sesionRepository,
    private readonly IAlumnoRepository $alumnoRepository,
    private readonly IAsistenciaRepository $asistenciaRepository
  ) {}

  public function execute(SesionDTO $dto): array {
    try {
      $sesion = $this->sesionRepository->findOrFail($dto);
      $asistencias = $this->asistenciaRepository->getBySesionId($sesion->id);

      foreach ($asistencias as $asistencia) {
        $sesion->addAsistencia($asistencia);
      }

      return [
        'created' => false,
        'sesion' => SesionTransformer::toArray($sesion)
      ];
    } catch (SesionNotFound) {
      $sesion = $this->sesionRepository->save($dto);
      $alumnos = $this->alumnoRepository->getByGrupoCursoId($dto->grupoId);

      $sesion->generarAsistencias($alumnos, $this->asistenciaRepository);

      return [
        'created' => true,
        'sesion' => SesionTransformer::toArray($sesion)
      ];
    }
  }
}
