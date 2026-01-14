<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetCursos;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

readonly class NotasController
{
    public function __construct(
        private GetCursos $getCursos,
    ) {}

    public function __invoke()
    {
        $cursos = $this->getCursos->execute(Id::fromInt(Auth::id()));

        return view('student.notas', compact('cursos'));
    }
}
