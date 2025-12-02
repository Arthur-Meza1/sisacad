<?php

namespace App\Infrastructure\Teacher\Controller;
use App\Application\Teacher\UseCase\GuardarAsistencia;
use App\Domain\Shared\Entity\Asistencia;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuardarAsistenciaController {
  public function __construct(
    private readonly GuardarAsistencia $guardarAsistencia,
  ) {}

  public function __invoke(Request $request) {
    $validated = $request->validate([
      'sesion_id' => 'required|integer|exists:sesions,id',
      'alumnos' => 'array',
      'alumnos.*' => 'in:0,1',
    ]);

    try {
      $this->guardarAsistencia->execute(
        sesionId:  Id::fromInt($validated['sesion_id']),
        asistencias:  $validated['alumnos'] ?? []
      );

      return response()->json([], Response::HTTP_CREATED);
    } catch(\Throwable $e) {
      return response()->json(["message" => $e->getMessage()], Response::HTTP_BAD_REQUEST);
    }
  }
}
