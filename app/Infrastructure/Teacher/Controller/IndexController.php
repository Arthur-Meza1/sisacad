<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

readonly class IndexController
{
  public function __construct(
    private GetBasicGruposData $getGruposData
  )
  {
  }

  public function __invoke(): View
  {
    return view('teacher.index', ['grupos' => $this->getGruposData->execute(Id::fromInt(Auth::id()))]);
  }
}
