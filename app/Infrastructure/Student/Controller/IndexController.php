<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetBasicGruposData;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

readonly class IndexController {
  public function __construct(
    private GetBasicGruposData $getBasicGruposData
  ) {
  }

  public function __invoke() {
    $grupos = $this->getBasicGruposData->execute(Id::fromInt(Auth::id()));

    return view('student.index', compact('grupos'));
  }
}
