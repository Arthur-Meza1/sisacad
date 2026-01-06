<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\ParseSyllabusPdf;
use App\Infrastructure\Shared\Model\Capitulo;
use App\Infrastructure\Shared\Model\Tema;
use App\Infrastructure\Shared\Model\GrupoCurso;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class UploadSyllabusController
{
  public function __construct(private ParseSyllabusPdf $parseSyllabusPdf) {}

  public function __invoke(Request $request): RedirectResponse
  {
    // 1. Validación de entrada
    $request->validate([
      'silabo' => 'required|file|mimes:pdf|max:10240',
      'grupo'  => 'required|integer',
    ]);

    $grupoId = $request->input('grupo');
    $file = $request->file('silabo');

    Log::info('Iniciando procesamiento de sílabo', [
      'grupo_id' => $grupoId,
      'archivo' => $file->getClientOriginalName()
    ]);

    // 2. Guardado del archivo
    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.-]/', '_', $file->getClientOriginalName());
    $path = $file->storeAs("public/silabos/{$grupoId}", $filename);

    if (!$path) {
      Log::error('Error al guardar el archivo');
      return back()->with('error', 'Error al subir el sílabo.');
    }

    $absolutePath = Storage::path($path);
    Log::info('Archivo guardado', ['path' => $absolutePath]);

    // 3. Extracción de texto
    try {
      $text = $this->parseSyllabusPdf->execute($absolutePath);
      Log::info('Texto extraído del PDF', ['tamano' => strlen($text)]);

      // Guardar para debug
      Storage::put("debug/syllabus_text_{$grupoId}.txt", $text);
    } catch (\Exception $e) {
      Log::error('Error al extraer texto del PDF', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
      return back()->with('error', 'Error al leer el PDF: ' . $e->getMessage());
    }

    // 4. Obtención de modelos
    try {
      $grupo = GrupoCurso::with('curso')->findOrFail($grupoId);
      $curso = $grupo->curso;

      Log::info('Curso encontrado', [
        'curso_id' => $curso->id,
        'curso_nombre' => $curso->nombre
      ]);
    } catch (\Exception $e) {
      Log::error('Error al obtener curso', [
        'grupo_id' => $grupoId,
        'error' => $e->getMessage()
      ]);
      return back()->with('error', 'Grupo o curso no encontrado.');
    }

    // 5. Procesamiento del contenido temático
    try {
      DB::beginTransaction();

      // Eliminar datos existentes
      $capitulosEliminados = Capitulo::where('curso_id', $curso->id)->delete();
      Log::info('Capítulos anteriores eliminados', ['count' => $capitulosEliminados]);

      // Procesar el contenido
      $resultados = $this->procesarSyllabusSimple($text, $curso);

      Log::info('Procesamiento completado', $resultados);

      DB::commit();

      return back()->with('success',
        "Sílabo procesado: {$resultados['capitulos']} capítulos y {$resultados['temas']} temas importados."
      );

    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error en procesamiento del sílabo', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
      return back()->with('error', 'Error al procesar el sílabo: ' . $e->getMessage());
    }
  }

  /**
   * Procesador simplificado sin dependencia de tabla unidades
   */

  // EN UploadSyllabusController, BUSCA y REEMPLAZA el método procesarSyllabusSimple:

  private function procesarSyllabusSimple(string $text, $curso): array
  {
    $capitulosCreados = 0;
    $temasCreados = 0;

    $text = preg_replace('/\r\n/', "\n", $text);
    $text = preg_replace('/\n+/', "\n", $text);

    $lines = explode("\n", $text);

    $enContenido = false;
    $capituloActual = null;
    $unidadNumero = 1;
    $capituloOrden = 1;
    $temaOrden = 1;

    foreach ($lines as $lineNumber => $line) {
      $line = trim($line);
      if (empty($line)) continue;

      // 1. Buscar CONTENIDO TEMÁTICO
      if (preg_match('/5\.[\s\.]*CONTENIDO[\s\.]*TEM[ÁA]TICO/i', $line)) {
        $enContenido = true;
        continue;
      }

      if (!$enContenido) continue;

      // 2. Detectar fin
      if (preg_match('/^6\./i', $line)) break;

      // 3. Detectar UNIDADES
      if (preg_match('/^\s*(PRIMERA|SEGUNDA|TERCERA|CUARTA)\s+UNIDAD/i', $line, $matches)) {
        $unidadNombre = strtoupper($matches[1]);
        $unidadNumero = match($unidadNombre) {
          'PRIMERA' => 1,
          'SEGUNDA' => 2,
          'TERCERA' => 3,
          'CUARTA' => 4,
          default => 1
        };

        $capituloOrden = 1;
        $capituloActual = null;
        continue;
      }

      // 4. Detectar CAPÍTULOS - CORREGIDO
      // Tu PDF tiene: "Capítulo I: Visión General de los SO"
      if (preg_match('/Capítulo\s+([IVXLCDM]+)\s*:\s*(.+)/i', $line, $matches)) {
        $numeroRomano = trim($matches[1]);
        $titulo = trim($matches[2]);

        // Limpiar si tiene asteriscos
        $titulo = preg_replace('/\*\*/', '', $titulo);
        $titulo = trim($titulo);

        $nombreCapitulo = "Capítulo {$numeroRomano}: {$titulo}";

        $capituloActual = Capitulo::create([
          'curso_id'  => $curso->id,
          'unidad_id' => $unidadNumero,
          'nombre'    => $nombreCapitulo,
          'orden'     => $capituloOrden++
        ]);

        $capitulosCreados++;
        $temaOrden = 1;

        continue;
      }

      // 5. Detectar TEMAS - CORREGIDO
      if (preg_match('/Tema\s+(\d+)\s*:\s*(.+)/i', $line, $matches)) {
        $numeroTema = str_pad(trim($matches[1]), 2, '0', STR_PAD_LEFT);
        $titulo = trim($matches[2]);

        $titulo = preg_replace('/\*\*/', '', $titulo);
        $titulo = trim($titulo);

        $nombreTema = "Tema {$numeroTema}: {$titulo}";

        // Si NO hay capítulo, crear uno
        if (!$capituloActual) {
          $capituloActual = Capitulo::create([
            'curso_id'  => $curso->id,
            'unidad_id' => $unidadNumero,
            'nombre'    => "Capítulo I: Sin título",
            'orden'     => $capituloOrden++
          ]);

          $capitulosCreados++;
          $temaOrden = 1;
        }

        Tema::create([
          'capitulo_id' => $capituloActual->id,
          'titulo'      => $nombreTema,
          'orden'       => $temaOrden++
        ]);

        $temasCreados++;
      }
    }

    return [
      'capitulos' => $capitulosCreados,
      'temas' => $temasCreados
    ];
  }
}
