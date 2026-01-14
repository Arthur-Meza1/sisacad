<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GuardarNotas;
use Illuminate\Http\Request;

class GuardarNotasController
{
    public function __construct(
        private readonly GuardarNotas $guardarNotas
    ) {}

    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'data' => ['required', 'array'],
            'data.*.registro_id' => ['required', 'integer'],
            'data.*.notas' => ['sometimes', 'array'],
            'data.*.notas.*' => ['nullable', 'numeric'],
        ]);

        $this->guardarNotas->execute($validated['data']);

        return response()->noContent();
    }
}
