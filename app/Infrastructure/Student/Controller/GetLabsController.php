<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetLabs;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

class GetLabsController
{
  public function __construct(
    private readonly GetLabs $getLabs
  ) {}
  public function __invoke() {
    return response()->json(
      $this->getLabs->execute(Id::fromInt(Auth::id()))
    );
  }
}
