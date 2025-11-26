<?php

namespace App\Infrastructure\Shared\Repository;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;

class EloquentSesionRepository implements ISesionRepository {
  public function save(SesionDTO $dto): void {
    EloquentSesion::create([
      'grupo_curso_id' => $dto->grupoId->getValue(),
      'aula_id' => $dto->aulaId->getValue(),
      'fecha' => $dto->fecha->getValue(),
      'horaInicio' => $dto->horaInicio->getValue(),
      'horaFin' => $dto->horaFin->getValue(),
      'from_bloque' => $dto->fromBloque
    ]);
  }
}
