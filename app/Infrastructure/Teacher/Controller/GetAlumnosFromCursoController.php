<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAlumnosFromCurso;
use App\Domain\Shared\ValueObject\Id;

class GetAlumnosFromCursoController
{
    public function __construct(
        private readonly GetAlumnosFromCurso $getAlumnosFromCurso
    ) {}

    public function __invoke(int $id)
    {
        $alumnos = $this->getAlumnosFromCurso->execute(Id::fromInt($id));

        return response()->json($alumnos);
    }
}
