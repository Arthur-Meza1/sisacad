<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetNotas;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

class GetNotasController
{
    public function __construct(
        private GetNotas $getNotas
    ) {}

    public function __invoke(int $grupoId)
    {
        return response()->json(
            $this->getNotas->execute(
                Id::fromInt(Auth::id()),
                Id::fromInt($grupoId)
            )
        );
    }
}
