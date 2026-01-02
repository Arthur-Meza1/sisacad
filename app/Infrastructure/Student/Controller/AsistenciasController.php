<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetAsistencias;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

class AsistenciasController
{
    public function __construct(
        private readonly GetAsistencias $getAsistencias,
    ) {}

    public function __invoke()
    {
        $asistencias = $this->getAsistencias->execute(Id::fromInt(Auth::id()));

        return view('student.asistencias', compact('asistencias'));
    }
}
