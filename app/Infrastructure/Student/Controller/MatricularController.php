<?php

namespace App\Infrastructure\Student\Controller;


use App\Application\Student\UseCase\MatricularLab;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class MatricularController
{
  public function __construct(
    private readonly MatricularLab $matricularLab
  ) {}
  public function __invoke(Request $request) {
    try {
      $validated = $request->validate([
        'id' => 'required|exists:grupo_cursos,id',
      ]);

      $this->matricularLab->execute(
        Id::fromInt(Auth::id()),
        Id::fromInt($validated['id']));

      return response()->json([], Response::HTTP_OK);
    } catch (\Throwable $th) {
      return response()->json(['error' => $th->getMessage()], Response::HTTP_BAD_REQUEST);
    }
  }
}
