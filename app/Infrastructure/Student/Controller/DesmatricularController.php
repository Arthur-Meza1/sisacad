<?php

namespace App\Infrastructure\Student\Controller;

use App\Application\Student\UseCase\DesmatricularLab;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DesmatricularController
{
  public function __construct(
    private readonly DesmatricularLab $desmatricularLab
  ) {}
  public function __invoke(Request $request) {
    try {
      $validated = $request->validate([
        'id' => 'required|exists:grupo_cursos,id',
      ]);

      $this->desmatricularLab->execute(
        Id::fromInt(Auth::id()),
        Id::fromInt($validated['id']));

      return response()->noContent();
    } catch (\Throwable $th) {
      return response()->withException($th);
    }
  }
}
