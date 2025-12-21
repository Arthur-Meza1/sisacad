<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetAulasDisponible;
use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Application\Teacher\UseCase\GetHorario;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

readonly class ReservarController
{

  public function __construct(
    private GetBasicGruposData $getGruposData,
    private GetHorario         $getHorariosData,
    private GetAulasDisponible $getAulasDisponible
  )
  {
  }

  public function __invoke(): View
  {
    $id = Id::fromInt(Auth::id());
    $today = Fecha::fromString(now().str());
    $inicio = Hora::fromString("00:00:00");
    $final = Hora::fromString("00:00:00");
    return view('teacher.horario.reservar', [
      'horario' => $this->getHorariosData->execute($id),
      'grupos' => $this->getGruposData->execute($id),
      // FIXME: No tengo idea de como solicitar esto no dinamicamente, probablemente se requira usar AJAX
      'aulas' => $this->getAulasDisponible->execute($today, $inicio, $final)]);
  }
}
