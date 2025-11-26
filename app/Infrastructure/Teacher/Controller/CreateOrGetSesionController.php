<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Shared\DTOs\SesionDTO;
use App\Application\Teacher\UseCase\CrearOrGetSesion;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateOrGetSesionController {
  public function __construct(
    private readonly CrearOrGetSesion $crearOrGetSesion
  ) {}

  public function __invoke(Request $request) {
    $validated = $request->validate([
      'grupo_id' => 'required',
      'fecha' => 'required',
      'hora_inicio' => 'required',
      'hora_fin' => 'required',
      'aula_id' => 'required',
    ]);

    try {
      $sesion = $this->crearOrGetSesion->execute(new SesionDTO(
        fecha:  Fecha::fromString($validated['fecha']),
        horaInicio:  Hora::fromString($validated['hora_inicio']),
        horaFin:  Hora::fromString($validated['hora_fin']),
        grupoId:  Id::fromInt($validated['grupo_id']),
        aulaId:  Id::fromInt($validated['aula_id']),
      ));

      return response()->json([
        'status' => 'sucess',
        'sesion' => $sesion
      ], Response::HTTP_CREATED);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
