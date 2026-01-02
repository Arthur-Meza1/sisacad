<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetNotas;
use App\Domain\Shared\ValueObject\Id;

class GetNotasController
{
    public function __construct(
        private GetNotas $getNotas
    ) {}

    public function __invoke(int $grupoId)
    {
        return response()->json(
            $this->getNotas->execute(Id::fromInt($grupoId))
        );
    }
}
