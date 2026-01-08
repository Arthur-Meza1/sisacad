<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Services\PdfTextCleaner;

final class ParseSyllabusPdf
{
  private PdfTextCleaner $textCleaner;

  public function __construct()
  {
    $this->textCleaner = new PdfTextCleaner();
  }

  public function execute(string $pdfPath): string
  {
    try {
      $parser = new \Smalot\PdfParser\Parser();
      $pdf = $parser->parseFile($pdfPath);
      $text = $pdf->getText();
      return $this->textCleaner->clean($text);

    } catch (\Exception $e) {
      \Log::error('Error parseo PDF', [
        'path' => $pdfPath,
        'error' => $e->getMessage()
      ]);

      throw new \RuntimeException(
        "Error al procesar el PDF: " . $e->getMessage()
      );
    }
  }
}
