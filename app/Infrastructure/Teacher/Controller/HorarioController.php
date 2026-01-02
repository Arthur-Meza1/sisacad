<?php

namespace App\Infrastructure\Teacher\Controller;


use App\Application\Teacher\UseCase\GetAulasDisponible;
use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Application\Teacher\UseCase\GetHorario;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

readonly class HorarioController
{
  public function __construct(
    private GetHorario         $getHorario,
    private GetBasicGruposData $getGruposData
  )
  {
  }

  public
  function __invoke(): View
  {
    $horario = $this->getHorario->execute(Id::fromInt(Auth::id()));
    $grupos = $this->getGruposData->execute(Id::fromInt(Auth::id()));

    return view('teacher.horario.index', compact('horario', 'grupos'));
  }
}
