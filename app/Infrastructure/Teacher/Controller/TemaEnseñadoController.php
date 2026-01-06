<?php
namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

readonly class TemaEnseñadoController
{
  public function toggle(Request $request): JsonResponse
  {
    // Primero prueba la conexión
    try {
      DB::connection()->getPdo();
      logger('Conexión a BD exitosa');
    } catch (\Exception $e) {
      logger('Error de conexión: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Error de conexión a la base de datos. Verifica que Sail esté corriendo.',
        'hint' => 'Ejecuta: ./vendor/bin/sail up -d'
      ], 500);
    }

    $request->validate([
      'grupo_id' => 'required|integer|exists:grupo_cursos,id',
      'tema_id' => 'required|integer|exists:temas,id',
      'enseñado' => 'required|boolean'
    ]);

    $docente = Auth::user()->docente;
    $grupoId = $request->grupo_id;

    // Verificar que el docente es el asignado
    $grupo = DB::table('grupo_cursos')
      ->where('id', $grupoId)
      ->where('docente_id', $docente->id)
      ->first();

    if (!$grupo) {
      return response()->json([
        'success' => false,
        'message' => 'No tienes permiso'
      ], 403);
    }

    try {
      if ($request->enseñado) {
        DB::table('grupo_tema')->updateOrInsert(
          [
            'grupo_id' => $grupoId,
            'tema_id' => $request->tema_id
          ],
          [
            'enseñado' => true,
            'fecha_enseñado' => now(),
            'updated_at' => now(),
            'created_at' => now()  // ¡ESTA ES LA LÍNEA CLAVE!
          ]
        );
        $message = 'Tema marcado como enseñado';
      } else {
        DB::table('grupo_tema')
          ->where('grupo_id', $grupoId)
          ->where('tema_id', $request->tema_id)
          ->update([
            'enseñado' => false,
            'fecha_enseñado' => null,
            'updated_at' => now()
          ]);
        $message = 'Tema desmarcado';
      }

      return response()->json([
        'success' => true,
        'message' => $message
      ]);

    } catch (\Exception $e) {
      logger('Error en toggle: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'sail_hint' => 'Verifica que la tabla grupo_tema exista. Ejecuta: ./vendor/bin/sail artisan migrate'
      ], 500);
    }
  }
}
