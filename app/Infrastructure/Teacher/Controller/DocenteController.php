<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

class DocenteController {
  public function __construct(
    private readonly GetBasicGruposData $getGruposData
  ) {
  }

  public function __invoke() {
    $grupos = $this->getGruposData->execute(Id::fromInt(Auth::id()));

    return view('teacher', compact('grupos'));
  }
}
