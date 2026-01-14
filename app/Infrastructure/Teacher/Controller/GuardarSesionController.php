<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GuardarAsistencia;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuardarSesionController
{
    public function __construct(
        private readonly GuardarAsistencia $guardarAsistencia,
    ) {}

    public function __invoke(int $id, Request $request)
    {
        $validated = $request->validate([
            'alumnos' => 'array',
            'alumnos.*' => 'in:0,1',
        ]);

        try {
            $this->guardarAsistencia->execute(
                sesionId: Id::fromInt($id),
                asistencias: $validated['alumnos'] ?? []
            );

            return response()->json([], Response::HTTP_CREATED);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
