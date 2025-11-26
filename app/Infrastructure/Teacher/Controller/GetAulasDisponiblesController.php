<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAulasDisponible;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GetAulasDisponiblesController {
  public function __construct(
    private readonly GetAulasDisponible $getAulasDisponible,
  ) {

  }

  public function __invoke(Request $request) {
    $validated = $request->validate([
      'fecha' => 'required',
      'hora_inicio' => 'required',
      'hora_fin' => 'required',
    ]);

    $aulas = $this->getAulasDisponible->execute(
      Fecha::fromString($validated['fecha']),
      Hora::fromString($validated['hora_inicio']),
      Hora::fromString($validated['hora_fin'])
    );

    return response()->json($aulas, Response::HTTP_OK);
  }
}
