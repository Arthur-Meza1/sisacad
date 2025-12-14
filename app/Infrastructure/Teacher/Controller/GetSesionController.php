<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetSesion;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Response;

class GetSesionController
{
  public function __construct(
    private readonly GetSesion $getSesion
  ) {}
  public function __invoke(int $id) {
    try {
      $res = $this->getSesion->execute(Id::fromInt($id));

      return response()->json($res, Response::HTTP_OK);
    } catch (\Exception $e) {
      return response()->json([
        'message' => $e->getMessage() . $e->getTraceAsString()
      ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
