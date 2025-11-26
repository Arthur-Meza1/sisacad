<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetHorario;
use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class GetHorarioController {
  public function __construct(
    private readonly GetHorario $getHorario,
  ) {

  }

  public function __invoke() {
    $horario = $this->getHorario->execute(Id::fromInt(Auth::id()));

    return response()->json($horario, Response::HTTP_OK);
  }
}
