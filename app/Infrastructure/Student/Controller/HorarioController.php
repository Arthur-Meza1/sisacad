<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetHorario;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

readonly class HorarioController
{
    public function __construct(
        private GetHorario $getHorario
    ) {}

    public function __invoke()
    {
        $horario = $this->getHorario->execute(Id::fromInt(Auth::id()));

        return view('student.horario', compact('horario'));
    }
}
