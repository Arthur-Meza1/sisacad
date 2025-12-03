<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetCursos;
use App\Domain\Shared\Exception\UserNotFound;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class GetCursosController {
  public function __construct(
    private readonly GetCursos $getCursos
  ) {}

  public function __invoke() {
    try {
      $cursos = $this->getCursos->execute(Id::fromInt(Auth::id()));

      return response()->json($cursos, Response::HTTP_OK);
    } catch(\Exception $e) {
      return response()->json([], Response::HTTP_NOT_FOUND);
    }
  }
}
