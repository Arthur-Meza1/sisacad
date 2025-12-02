<?php

namespace App\Application\Teacher\UseCase;
use App\Domain\Shared\Entity\Asistencia;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Id;

class GuardarAsistencia {
  public function __construct(
    private readonly ISesionRepository $sesionRepository,
  ) {}

  /**
   * @param Asistencia[] $asistencias
   * @return void
   */
  public function execute(
    Id $sesionId,
    array $asistencias
  ): void {
    $sesion = $this->sesionRepository->findByIdOrFail($sesionId);

    foreach ($asistencias as $id => $presente) {
      $sesion->registrarAsistencia(Id::fromInt($id), null, AsistenciaEstado::fromString($presente));
    }

    $this->sesionRepository->update($sesion);
  }
}
