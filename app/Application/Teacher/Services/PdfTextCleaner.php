<?php

namespace App\Application\Teacher\Services;

use ForceUTF8\Encoding;

class PdfTextCleaner
{
  public function clean(string $text): string
  {
    $text = $this->cleanControlCharacters($text);

    $text = $this->detectAndConvertEncoding($text);

    $text = $this->fixPeruvianMojibake($text);

    $text = $this->normalizeOutput($text);

    return $text;
  }

  private function cleanControlCharacters(string $text): string
  {
    return preg_replace(
      '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F-\x9F]/u',
      '',
      $text
    );
  }

  private function detectAndConvertEncoding(string $text): string
  {
    $commonEncodings = [
      'UTF-8',
      'Windows-1252',
      'ISO-8859-1',
      'CP850',
      'ASCII',
    ];

    $detected = mb_detect_encoding($text, $commonEncodings, true);

    if ($detected && $detected !== 'UTF-8') {
      $text = mb_convert_encoding($text, 'UTF-8', $detected);
    }

    return Encoding::toUTF8($text);
  }

  private function fixPeruvianMojibake(string $text): string
  {
    $replacements = [
      'AGUSTÃŽN' => 'AGUSTÍN',
      'ACADÃ‰MICO' => 'ACADÉMICO',
      'SÃŽLABO' => 'SÍLABO',
      'ESTADÃ­STICA' => 'ESTADÍSTICA',
      'INFORMACIÃ"N' => 'INFORMACIÓN',
      'COMPUTACIÃ"N' => 'COMPUTACIÓN',
      'PROBABILIDADES' => 'PROBABILIDADES',
      'NATURALES Y FORMALES' => 'NATURALES Y FORMALES',

      'Ã¡' => 'á', 'Ã©' => 'é', 'Ã­' => 'í', 'Ã³' => 'ó', 'Ãº' => 'ú',
      'Ã' => 'Á', 'Ã‰' => 'É', 'Ã' => 'Í', 'Ã“' => 'Ó', 'Ãš' => 'Ú',
      'Ã±' => 'ñ', 'Ã‘' => 'Ñ',

      'Â¡' => '¡', 'Â¿' => '¿',

      'â€œ' => '"', 'â€' => '"', 'â€˜' => "'", 'â€™' => "'",
      'â€”' => '—', 'â€“' => '–', 'â€¦' => '…',

      'Â°' => '°', 'Â±' => '±', 'Â²' => '²', 'Â³' => '³',

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
