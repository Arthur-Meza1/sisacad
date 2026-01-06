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
  private function procesarSyllabusSimple(string $text, $curso): array
  {
    $capitulosCreados = 0;
    $temasCreados = 0;

    // Normalizar texto
    $text = preg_replace('/\r\n/', "\n", $text);
    $text = preg_replace('/\n+/', "\n", $text);

    $lines = explode("\n", $text);

    // Variables de estado
    $enContenido = false;
    $capituloActual = null;
    $unidadNumero = 1; // Número de unidad (1, 2, 3, ...)
    $capituloOrden = 1;
    $temaOrden = 1;

    Log::info('Procesando sílabo (método simple)', ['lineas' => count($lines)]);

    foreach ($lines as $lineNumber => $line) {
      $line = trim($line);
      if (empty($line)) continue;

      // DEBUG: Ver primeras líneas
      if ($lineNumber < 20) {
        Log::debug("Línea {$lineNumber}: " . substr($line, 0, 100));
      }

      // 1. Buscar inicio de CONTENIDO TEMÁTICO
      if (preg_match('/5\.[\s\.]*CONTENIDO[\s\.]*TEM[ÁA]TICO/i', $line) ||
        preg_match('/^CONTENIDO[\s\.]*TEM[ÁA]TICO/i', $line)) {
        $enContenido = true;
        Log::info("✓ Encontrado CONTENIDO TEMÁTICO en línea {$lineNumber}");
        continue;
      }

      // Si no estamos en contenido, continuar
      if (!$enContenido) {
        continue;
      }

      // 2. Detectar fin de sección
      if (preg_match('/^6\./i', $line) ||
        preg_match('/ESTRATEGIAS DE ENSEÑANZA/i', $line) ||
        preg_match('/CRONOGRAMA ACAD[ÉE]MICO/i', $line)) {
        Log::info("Fin de sección en línea {$lineNumber}");
        break;
      }

      // 3. Detectar UNIDADES
      if (preg_match('/^\s*(PRIMERA|SEGUNDA|TERCERA|CUARTA|QUINTA|SEXTA)\s+UNIDAD/i', $line, $matches)) {
        $unidadNombre = strtoupper($matches[1]);
        $unidadNumero = match($unidadNombre) {
          'PRIMERA' => 1,
          'SEGUNDA' => 2,
          'TERCERA' => 3,
          'CUARTA'  => 4,
          'QUINTA'  => 5,
          'SEXTA'   => 6,
          default   => 1
        };

        Log::info("→ Cambio a {$unidadNombre} (Unidad #{$unidadNumero})");

        // Reiniciar contadores
        $capituloOrden = 1;
        $capituloActual = null;
        continue;
      }

      // 4. Detectar CAPÍTULOS (aceptar diferentes formatos)
      if (preg_match('/Cap[íi]tulo\s+([IVXLCDM]+|[A-Z])\s*[:\-\.]?\s*(.+)/i', $line, $matches)) {
        $numero = trim($matches[1]);
        $titulo = trim($matches[2]);

        // Limpiar asteriscos si existen
        $titulo = preg_replace('/\*\*/', '', $titulo);

        $nombreCapitulo = "Capítulo {$numero}: {$titulo}";

        $capituloActual = Capitulo::create([
          'curso_id'  => $curso->id,
          'unidad_id' => $unidadNumero, // Solo el número, sin foreign key
          'nombre'    => $nombreCapitulo,
          'orden'     => $capituloOrden++
        ]);

        $capitulosCreados++;
        $temaOrden = 1;

        Log::info("✓ Capítulo creado: {$nombreCapitulo}", [
          'unidad' => $unidadNumero,
          'orden' => $capituloOrden - 1
        ]);
        continue;
      }

      // 5. Detectar TEMAS (formato: Tema 01:, Tema 02:, etc.)
      if (preg_match('/Tema\s+(\d{1,3})\s*[:\-\.]?\s*(.+)/i', $line, $matches)) {
        $numeroTema = str_pad(trim($matches[1]), 2, '0', STR_PAD_LEFT);
        $titulo = trim($matches[2]);

        // Limpiar asteriscos
        $titulo = preg_replace('/\*\*/', '', $titulo);

        $nombreTema = "Tema {$numeroTema}: {$titulo}";

        // Si no hay capítulo, crear uno automático
        if (!$capituloActual) {
          $capituloActual = Capitulo::create([
            'curso_id'  => $curso->id,
            'unidad_id' => $unidadNumero,
            'nombre'    => "Capítulo I: Sin título",
            'orden'     => $capituloOrden++
          ]);

          $capitulosCreados++;
          $temaOrden = 1;

          Log::warning("⚠ Creando capítulo automático para: {$nombreTema}");
        }

        Tema::create([
          'capitulo_id' => $capituloActual->id,
          'titulo'      => $nombreTema,
          'orden'       => $temaOrden++
        ]);

        $temasCreados++;

        Log::debug("✓ Tema creado: {$nombreTema}", [
          'capitulo' => $capituloActual->nombre,
          'orden' => $temaOrden - 1
        ]);
      }
    }

    // Si no encontró nada, intentar método de emergencia
    if ($capitulosCreados === 0) {
      Log::warning('Método principal no funcionó, intentando búsqueda directa');
      return $this->busquedaDirectaEnTexto($text, $curso);
    }

    return [
      'capitulos' => $capitulosCreados,
      'temas' => $temasCreados,
      'lineas' => count($lines)
    ];
  }

  /**
   * Método de emergencia: búsqueda directa de patrones
   */
  private function busquedaDirectaEnTexto(string $text, $curso): array
  {
    $capitulosCreados = 0;
    $temasCreados = 0;

    Log::info('Iniciando búsqueda directa de emergencia');

    // Buscar capítulos en todo el texto
    preg_match_all('/Cap[íi]tulo\s+([IVXLCDM]+|[A-Z])\s*[:\-\.]?\s*([^\n]+)/i', $text, $capMatches);

    // Buscar temas en todo el texto
    preg_match_all('/Tema\s+(\d+)\s*[:\-\.]?\s*([^\n]+)/i', $text, $temaMatches);

    Log::info('Resultados búsqueda directa:', [
      'capitulos' => count($capMatches[0]),
      'temas' => count($temaMatches[0])
    ]);

    // Crear capítulos
    if (!empty($capMatches[0])) {
      $unidadActual = 1;
      $capituloOrden = 1;

      for ($i = 0; $i < count($capMatches[0]); $i++) {
        $numero = trim($capMatches[1][$i]);
        $titulo = trim($capMatches[2][$i]);
        $titulo = preg_replace('/\*\*/', '', $titulo);

        $nombre = "Capítulo {$numero}: {$titulo}";

        // Cambiar de unidad cada 2 capítulos
        if ($capituloOrden > 2) {
          $unidadActual = min($unidadActual + 1, 4);
          $capituloOrden = 1;
        }

        Capitulo::create([
          'curso_id'  => $curso->id,
          'unidad_id' => $unidadActual,
          'nombre'    => $nombre,
          'orden'     => $capituloOrden++
        ]);

        $capitulosCreados++;
      }
    }

    // Crear temas y asignar a capítulos
    if (!empty($temaMatches[0])) {
      // Obtener todos los capítulos del curso
      $capitulos = Capitulo::where('curso_id', $curso->id)
        ->orderBy('unidad_id')
        ->orderBy('orden')
        ->get();

      if ($capitulos->isNotEmpty()) {
        $capituloIndex = 0;
        $temaOrden = 1;
        $capituloActual = $capitulos[$capituloIndex];

        for ($i = 0; $i < count($temaMatches[0]); $i++) {
          $numero = str_pad(trim($temaMatches[1][$i]), 2, '0', STR_PAD_LEFT);
          $titulo = trim($temaMatches[2][$i]);
          $titulo = preg_replace('/\*\*/', '', $titulo);

          $nombre = "Tema {$numero}: {$titulo}";

          Tema::create([
            'capitulo_id' => $capituloActual->id,
            'titulo'      => $nombre,
            'orden'       => $temaOrden++
          ]);

          $temasCreados++;

          // Cambiar de capítulo después de varios temas
          if ($temaOrden > 6 && $capituloIndex < $capitulos->count() - 1) {
            $capituloIndex++;
            $capituloActual = $capitulos[$capituloIndex];
            $temaOrden = 1;
          }
        }
      }
    }

    return [
      'capitulos' => $capitulosCreados,
      'temas' => $temasCreados,
      'metodo' => 'busqueda_directa'
    ];
  }
}
