<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetCupos;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

class GetCuposController {
  public function __construct(
    private readonly GetCupos $getCupos
  ) {}
  public function __invoke() {
    return response()->json(
      $this->getCupos->execute(Id::fromInt(Auth::id()))
    );
  }
}
