<?php

namespace App\Infrastructure\Teacher\Controller;


use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

readonly class HorarioController
{
  public function __construct(
    private GetBasicGruposData $getGruposData
  )
  {
  }

  public function __invoke(): View
  {
    $grupos = $this->getGruposData->execute(Id::fromInt(Auth::id()));
    return view('teacher.horario', compact('grupos'));
  }
}
