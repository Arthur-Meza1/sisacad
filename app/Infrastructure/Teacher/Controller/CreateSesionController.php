<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Shared\DTOs\SesionDTO;
use App\Application\Teacher\UseCase\CrearSesion;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateSesionController {
  public function __construct(
    private readonly CrearSesion $crearSesion
  ) {}

  public function __invoke(Request $request) {
    $validated = $request->validate([
      'grupo_id' => 'required|exists:grupo_cursos,id',
      'fecha' => 'required|date',
      'hora_inicio' => 'required|date_format:H:i',
      'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
      'aula_id' => 'required|exists:aulas,id',
      'from_bloque' => 'required'
    ]);

    try {
      $this->crearSesion->execute(new SesionDTO(
        grupoId:  Id::fromInt($validated['grupo_id']),
        fecha:  Fecha::fromString($validated['fecha']),
        horaInicio:  Hora::fromString($validated['hora_inicio']),
        horaFin:  Hora::fromString($validated['hora_fin']),
        aulaId:  Id::fromInt($validated['aula_id']),
        fromBloque: (bool)(int)$validated['from_bloque']
      ));

      return response()->json([], Response::HTTP_CREATED);
    } catch (\Exception $e) {
      return response()->json([ 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
