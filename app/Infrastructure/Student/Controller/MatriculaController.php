<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\GetCupos;
use App\Application\Student\UseCase\GetLabs;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Auth;

readonly class MatriculaController
{
  public function __construct(
    private GetLabs $getLabs,
    private GetCupos $getCupos,
  ) {}
  public function __invoke() {
    $id = Id::fromInt(Auth::id());
    $labs = $this->getLabs->execute($id);
    $cupos = $this->getCupos->execute($id);
    return view('student.matricula', compact('labs', 'cupos'));
  }
}
