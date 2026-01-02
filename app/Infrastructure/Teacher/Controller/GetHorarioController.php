<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetHorario;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GetHorarioController
{
    public function __construct(
        private readonly GetHorario $getHorario,
    ) {}

    public function __invoke()
    {
        $horario = $this->getHorario->execute(Id::fromInt(Auth::id()));

        return response()->json($horario, Response::HTTP_OK);
    }
}
