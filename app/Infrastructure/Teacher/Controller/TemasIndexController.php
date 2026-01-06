<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\Tema;

readonly class TemasIndexController
{
  public function __invoke($grupoId): View
  {
    $docente = Auth::user()->docente;
    $grupo = GrupoCurso::with('curso')->findOrFail($grupoId);

    // Verificar que el docente es el asignado
    if ($grupo->docente_id !== $docente->id) {
      abort(403, 'No eres el docente asignado a este grupo');
    }

    // 1. Obtener todos los temas del curso, agrupados por capítulo
    $capitulosConTemas = DB::table('capitulos')
      ->join('temas', 'capitulos.id', '=', 'temas.capitulo_id')
      ->where('capitulos.curso_id', $grupo->curso_id)
      ->select(
        'capitulos.id as capitulo_id',
        'capitulos.nombre as capitulo_nombre',
        'capitulos.unidad_id',
        'capitulos.orden as capitulo_orden',
        'temas.id as tema_id',
        'temas.titulo as tema_titulo',
        'temas.orden as tema_orden'
      )
      ->orderBy('capitulos.unidad_id')
      ->orderBy('capitulos.orden')
      ->orderBy('temas.orden')
      ->get();

    // 2. Obtener estado de enseñanza para ESTE grupo
    $estadosTemas = DB::table('grupo_tema')
      ->where('grupo_id', $grupoId)
      ->get()
      ->keyBy('tema_id');

    // 3. Organizar datos
    $unidades = [
      1 => 'PRIMERA UNIDAD',
      2 => 'SEGUNDA UNIDAD',
      3 => 'TERCERA UNIDAD',
      4 => 'CUARTA UNIDAD'
    ];

    $estructura = [];
    $totalTemas = 0;
    $temasEnseñados = 0;

    foreach ($capitulosConTemas as $item) {
      $totalTemas++;

      $estado = $estadosTemas[$item->tema_id] ?? null;
      $enseñado = $estado && $estado->enseñado;

      if ($enseñado) {
        $temasEnseñados++;
      }

      $unidadId = $item->unidad_id;
      $capituloId = $item->capitulo_id;

      if (!isset($estructura[$unidadId])) {
        $estructura[$unidadId] = [
          'nombre' => $unidades[$unidadId] ?? "UNIDAD $unidadId",
          'capitulos' => []
        ];
      }

      if (!isset($estructura[$unidadId]['capitulos'][$capituloId])) {
        $estructura[$unidadId]['capitulos'][$capituloId] = [
          'nombre' => $item->capitulo_nombre,
          'temas' => []
        ];
      }

      $estructura[$unidadId]['capitulos'][$capituloId]['temas'][] = [
        'id' => $item->tema_id,
        'titulo' => $item->tema_titulo,
        'orden' => $item->tema_orden,
        'enseñado' => $enseñado,
        'fecha_enseñado' => $estado?->fecha_enseñado,
        'notas' => $estado?->notas
      ];
    }

    $porcentaje = $totalTemas > 0 ? round(($temasEnseñados / $totalTemas) * 100) : 0;

    return view('teacher.temas.index', [
      'grupo' => $grupo,
      'estructura' => $estructura,
      'totalTemas' => $totalTemas,
      'temasEnseñados' => $temasEnseñados,
      'porcentaje' => $porcentaje
    ]);
  }
}
