<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Transformer\SesionTransformer;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\Id;

class GetSesion
{
  public function __construct(
    private readonly ISesionRepository $sesionRepository
  ) {}

  public function execute(Id $id): array {
    return SesionTransformer::toArray(
      $this->sesionRepository->findByIdOrFail($id)
    );
  }
}
