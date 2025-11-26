<?php

namespace App\Domain\Shared\Repository;

use App\Application\Shared\DTOs\SesionDTO;

interface ISesionRepository {
  public function save(SesionDTO $dto): void;
}
