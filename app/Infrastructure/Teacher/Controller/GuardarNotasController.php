<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GuardarNotas;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\NotasContinua;
use App\Domain\Shared\ValueObject\NotasParcial;
use App\Domain\Shared\ValueObject\Registro;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuardarNotasController
{
  public function __construct(
    private readonly GuardarNotas $guardarNotas
  ) {}
  public function __invoke(Request $request) {
    $validated = $request->validate([
      'data' => ['required', 'array'],
      'data.*.registro_id' => ['required', 'integer'],
      'data.*.notas' => ['required', 'array'],
      'data.*.notas.*' => ['required', 'numeric'],
    ]);

    $this->guardarNotas->execute(
      array_map(
        function ($item) {
          $parciales = new NotasParcial(
            $item['notas']['parcial1'] ?? null,
            $item['notas']['parcial1'] ?? null,
            $item['notas']['parcial1'] ?? null,
            $item['notas']['sustitutorio'] ?? null,
          );
          $continuas = new NotasContinua(
            $item['notas']['continua1'] ?? null,
            $item['notas']['continua2'] ?? null,
            $item['notas']['continua3'] ?? null,
          );

          return new Registro(Id::fromInt($item['registro_id']), $parciales, $continuas);
        },
        $validated['data'])
    );

    return response()->json([], Response::HTTP_OK);
  }
}
