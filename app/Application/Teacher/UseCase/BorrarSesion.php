<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\Id;

class BorrarSesion
{
    public function __construct(
        private readonly ISesionRepository $sesionRepository,
    ) {}

    public function execute(Id $id): void
    {
        $this->sesionRepository->deleteOrFail($id);
    }
}
