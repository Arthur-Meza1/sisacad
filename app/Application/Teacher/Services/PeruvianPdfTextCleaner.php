<?php

namespace App\Application\Teacher\Services;

use ForceUTF8\Encoding;

class PeruvianPdfTextCleaner
{
  public function clean(string $text): string
  {
    // Paso 1: Limpieza básica
    $text = $this->cleanControlCharacters($text);

    // Paso 2: Detectar codificación específica de UNSA/Perú
    $text = $this->detectAndConvertEncoding($text);

    // Paso 3: Reparar mojibake específico
    $text = $this->fixPeruvianMojibake($text);

    // Paso 4: Normalización final
    $text = $this->normalizeOutput($text);

    return $text;
  }

  private function cleanControlCharacters(string $text): string
  {
    // Mantener saltos de línea y tabs, eliminar otros controles
    return preg_replace(
      '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u',
      '',
      $text
    );
  }

  private function detectAndConvertEncoding(string $text): string
  {
    // Los PDFs de UNSA suelen usar Windows-1252 o ISO-8859-1
    $commonEncodings = [
      'UTF-8',
      'Windows-1252',  // Muy común en Perú
      'ISO-8859-1',    // Latin-1
      'CP850',         // DOS
      'ASCII',
    ];

    // Intentar detectar
    $detected = mb_detect_encoding($text, $commonEncodings, true);

    if ($detected && $detected !== 'UTF-8') {
      $text = mb_convert_encoding($text, 'UTF-8', $detected);
    }

    // Forzar UTF-8 válido
    return Encoding::toUTF8($text);
  }

  private function fixPeruvianMojibake(string $text): string
  {
    // Mapeo de problemas específicos encontrados en UNSA
    $replacements = [
      // Títulos UNSA
      'AGUSTÃŽN' => 'AGUSTÍN',
      'ACADÃ‰MICO' => 'ACADÉMICO',
      'SÃŽLABO' => 'SÍLABO',
      'ESTADÃ­STICA' => 'ESTADÍSTICA',
      'INFORMACIÃ"N' => 'INFORMACIÓN',
      'COMPUTACIÃ"N' => 'COMPUTACIÓN',
      'PROBABILIDADES' => 'PROBABILIDADES',
      'NATURALES Y FORMALES' => 'NATURALES Y FORMALES',

      // Caracteres acentuados
      'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãº' => 'ú',
      'Ã' => 'Á', 'Ã‰' => 'É', 'Ã' => 'Í', 'Ã“' => 'Ó', 'Ãš' => 'Ú',
      'Ã±' => 'ñ', 'Ã‘' => 'Ñ',

      // Puntuación española
      'Â¡' => '¡', 'Â¿' => '¿',

      // Comillas y guiones
      'â€œ' => '"', 'â€' => '"', 'â€˜' => "'", 'â€™' => "'",
      'â€”' => '—', 'â€“' => '–', 'â€¦' => '…',

      // Símbolos matemáticos
      'Â°' => '°', 'Â±' => '±', 'Â²' => '²', 'Â³' => '³',

      // Errores comunes de codificación
      'Ã§' => 'ç', 'Ã£' => 'ã', 'Ãµ' => 'õ',
      'Ã¨' => 'è', 'Ãª' => 'ê', 'Ã«' => 'ë',
      'Ã¯' => 'ï', 'Ã°' => 'ð',
    ];

    return strtr($text, $replacements);
  }

  private function normalizeOutput(string $text): string
  {
    // Unificar saltos de línea
    $text = str_replace(["\r\n", "\r"], "\n", $text);

    // Eliminar múltiples espacios
    $text = preg_replace('/[ \t]+/', ' ', $text);

    // Eliminar múltiples saltos de línea
    $text = preg_replace('/\n{3,}/', "\n\n", $text);

    // Trim de cada línea
    $lines = explode("\n", $text);
    $lines = array_map('trim', $lines);

    return implode("\n", array_filter($lines));
  }
}
