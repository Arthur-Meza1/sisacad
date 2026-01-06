<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\View\View;
use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\Curso;
use Illuminate\Support\Facades\DB;

readonly class TemasIndexController
{
  public function __invoke($grupoId): View
  {
    // OPCIÓN 1: Carga eager con relaciones anidadas
    $grupo = GrupoCurso::with(['curso.capitulos.temas'])->findOrFail($grupoId);

    // DEBUG: Ver qué datos tenemos
    // dd($grupo->toArray()); // Descomenta para ver TODOS los datos
    // dd($grupo->curso); // Descomenta para ver solo el curso
    // dd($grupo->curso->capitulos); // Descomenta para ver los capítulos

    // Si $grupo->curso->capitulos está vacío, vamos a verificar en la BD
    if ($grupo->curso->capitulos->isEmpty()) {
      // Verificar directamente en la base de datos
      $cursoId = $grupo->curso->id;
      $capitulosCount = DB::table('capitulos')->where('curso_id', $cursoId)->count();
      $temasCount = DB::table('temas')->count();

      // Agregar esta info a la vista para debuggear
      return view('teacher.temas.index', compact('grupo'))
        ->with('debug', [
          'curso_id' => $cursoId,
          'capitulos_count' => $capitulosCount,
          'temas_count' => $temasCount,
          'message' => 'No se encontraron capítulos. Verifica que el parser guardó los datos correctamente.'
        ]);
    }

    return view('teacher.temas.index', compact('grupo'));
  }
}
