<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\ParseSyllabusPdf;
use App\Infrastructure\Shared\Model\Capitulo;
use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Shared\Model\Tema;
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
      'curso'  => 'required|integer',
    ]);

    $cursoId = $request->input('curso');
    $file = $request->file('silabo');

    Log::info('Iniciando procesamiento de sílabo', [
      'cursoId' => $cursoId,
      'archivo' => $file->getClientOriginalName()
    ]);

    // 2. Guardado del archivo
    $filename = time() . '_' . preg_replace('/[^A-Za-z0-9.-]/', '_', $file->getClientOriginalName());
    $path = $file->storeAs("public/silabos/{$cursoId}", $filename);

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
      Storage::put("debug/syllabus_text_{$cursoId}.txt", $text);
    } catch (\Exception $e) {
      Log::error('Error al extraer texto del PDF', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
      return back()->with('error', 'Error al leer el PDF: ' . $e->getMessage());
    }

    // 4. Obtención de modelos
    try {
      $curso = Curso::findOrFail($cursoId);

      Log::info('Curso encontrado', [
        'curso_id' => $curso->id,
        'curso_nombre' => $curso->nombre
      ]);
    } catch (\Exception $e) {
      Log::error('Error al obtener curso', [
        'curso_id' => $cursoId,
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
        "Sílabo procesado: " .
        "{$resultados['capitulos']} capítulos, " .
        "{$resultados['temas']} temas. " .
        ($resultados['creditos'] ? "Créditos: {$resultados['creditos']}. " : "") .
        ($resultados['pesos']['p1'] ? "Pesos extraídos." : "")
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



  private function procesarSyllabusSimple(string $text, $curso): array
  {
    $capitulosCreados = 0;
    $temasCreados = 0;

    // Variables para extraer datos adicionales
    $creditos = null;
    $pesos = [
      'p1' => null, 'p2' => null, 'p3' => null,
      'c1' => null, 'c2' => null, 'c3' => null
    ];

    $text = str_replace('/\r\n/', "\n", $text);
    $text = str_replace('/\n+/', "\n", $text);

    $lines = explode("\n", $text);

    $enContenido = false;
    $capituloActual = null;
    $unidadNumero = 1;
    $capituloOrden = 1;
    $temaOrden = 1;

    foreach ($lines as $lineNumber => $line) {
      $line = trim($line);
      if (empty($line)) continue;

      // 1. EXTRACCIÓN DE CRÉDITOS (antes del contenido temático)
      if (preg_match('/Número\s+de\s+créditos\s*:\s*(\d+(?:\.\d+)?)/i', $line, $matches)) {
        $creditos = floatval($matches[1]);
        Log::info('Créditos detectados', ['creditos' => $creditos]);
      }

      // 2. EXTRACCIÓN DE PESOS DE EVALUACIÓN
      if (preg_match('/Cronograma\s+de\s+evaluación.*?Primera\s+Evaluación\s+Parcial.*?(\d+(?:\.\d+)?)%\D*(\d+(?:\.\d+)?)%.*?Segunda\s+Evaluación\s+Parcial.*?(\d+(?:\.\d+)?)%\D*(\d+(?:\.\d+)?)%.*?Tercera\s+Evaluación\s+Parcial.*?(\d+(?:\.\d+)?)%\D*(\d+(?:\.\d+)?)%/is', $text, $matches)) {
        if (isset($matches[1])) $pesos['p1'] = floatval($matches[1]);
        if (isset($matches[2])) $pesos['c1'] = floatval($matches[2]);
        if (isset($matches[3])) $pesos['p2'] = floatval($matches[3]);
        if (isset($matches[4])) $pesos['c2'] = floatval($matches[4]);
        if (isset($matches[5])) $pesos['p3'] = floatval($matches[5]);
        if (isset($matches[6])) $pesos['c3'] = floatval($matches[6]);

        Log::info('Pesos encontrados mediante patrón de tabla', $pesos);
      }

      // PATRÓN 3: Buscar por líneas específicas (más robusto)
      if (preg_match('/Primera\s+Evaluación\s+Parcial[^%]*?(\d+(?:\.\d+)?)%[^%]*?(\d+(?:\.\d+)?)%/i', $text, $matches)) {
        $pesos['p1'] = floatval($matches[1]);
        $pesos['c1'] = floatval($matches[2]);
      }

      if (preg_match('/Segunda\s+Evaluación\s+Parcial[^%]*?(\d+(?:\.\d+)?)%[^%]*?(\d+(?:\.\d+)?)%/i', $text, $matches)) {
        $pesos['p2'] = floatval($matches[1]);
        $pesos['c2'] = floatval($matches[2]);
      }

      if (preg_match('/Tercera\s+Evaluación\s+Parcial[^%]*?(\d+(?:\.\d+)?)%[^%]*?(\d+(?:\.\d+)?)%/i', $text, $matches)) {
        $pesos['p3'] = floatval($matches[1]);
        $pesos['c3'] = floatval($matches[2]);
      }

      // 3. Buscar CONTENIDO TEMÁTICO
      if (preg_match('/5\.[\s\.]*CONTENIDO[\s\.]*TEM[ÁA]TICO/i', $line)) {
        $enContenido = true;

        // Si ya extrajimos créditos y pesos, actualizar el curso
        $this->actualizarInformacionCurso($curso, $creditos, $pesos);

        continue;
      }

      if (!$enContenido) continue;

      // 4. Detectar fin
      if (preg_match('/^6\./i', $line)) break;

      // 5. Detectar UNIDADES
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

      // 6. Detectar CAPÍTULOS
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

      // 7. Detectar TEMAS
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

    // Si no encontramos antes del contenido, buscar después
    if ($creditos === null || array_filter($pesos) === array_fill_keys(array_keys($pesos), null)) {
      $this->buscarInformacionAdicional($text, $curso, $creditos, $pesos);
    }

    return [
      'capitulos' => $capitulosCreados,
      'temas' => $temasCreados,
      'creditos' => $creditos,
      'pesos' => $pesos
    ];
  }

  private function actualizarInformacionCurso($curso, $creditos, $pesos)
  {
    try {
      $actualizaciones = [];

      if ($creditos !== null) {
        $curso->creditos = $creditos;
        $actualizaciones['creditos'] = $creditos;
      }

      $columnas = [
        'p1' => 'peso_p1', 'c1' => 'peso_c1',
        'p2' => 'peso_p2', 'c2' => 'peso_c2',
        'p3' => 'peso_p3', 'c3' => 'peso_c3'
      ];

      foreach ($columnas as $key => $columna) {
        if (isset($pesos[$key]) && $pesos[$key] !== null) {
          $curso->{$columna} = $pesos[$key];
          $actualizaciones[$columna] = $pesos[$key];
        }
      }

      if (!empty($actualizaciones)) {
        $curso->save();
        Log::info('Información del curso actualizada', $actualizaciones);
      } else {
        Log::warning('No se encontró información para actualizar en el curso');
      }

    } catch (\Exception $e) {
      Log::error(' Error al actualizar información del curso', [
        'curso_id' => $curso->id,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
      ]);
    }
  }


}
