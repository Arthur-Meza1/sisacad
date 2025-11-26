<?php

namespace App\Domain\Shared\Repository;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Entity\Sesion;

interface ISesionRepository {
  public function findOrFail(SesionDTO $sesionDTO): Sesion;
  public function save(SesionDTO $dto): Sesion;
}
