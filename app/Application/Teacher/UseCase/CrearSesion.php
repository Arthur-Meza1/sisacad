<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Repository\ISesionRepository;

class CrearSesion {
  public function __construct(
    private readonly ISesionRepository $sesionRepository
  ) {}

  public function execute(SesionDTO $dto): void {
    $this->sesionRepository->save($dto);
  }
}
