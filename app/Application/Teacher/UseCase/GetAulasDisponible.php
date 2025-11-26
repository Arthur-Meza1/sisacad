<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Transformer\AulaTransformer;
use App\Domain\Shared\Repository\IAulaRepository;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Repository\IDocenteRepository;

class GetAulasDisponible {
  public function __construct(
    private readonly IAulaRepository $aulaRepository,
  ) {}

  public function execute(Fecha $fecha, Hora $horaInicio, Hora $horaFin): array {
    $dtos = $this->aulaRepository->getDisponiblesDTOsBetween($fecha, $horaInicio, $horaFin);

    return AulaTransformer::toArray($dtos);
  }
}
