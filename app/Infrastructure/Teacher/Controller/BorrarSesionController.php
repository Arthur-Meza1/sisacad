<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\BorrarSesion;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Response;

class BorrarSesionController
{
  public function __construct(
    private readonly BorrarSesion $borrarSesion
  ) {}
  public function __invoke(int $id) {
    try {
      $this->borrarSesion->execute(Id::fromInt($id));

      return response()->json([], Response::HTTP_OK);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage() . $e->getTraceAsString()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
