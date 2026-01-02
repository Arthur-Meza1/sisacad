<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetBasicGruposData;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

readonly class DocenteController
{
    public function __construct(
        private GetBasicGruposData $getGruposData
    ) {}

    public function __invoke(): View
    {
        $grupos = $this->getGruposData->execute(Id::fromInt(Auth::id()));

        return view('teacher.index', compact('grupos'));
    }
}
