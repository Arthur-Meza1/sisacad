<?php

namespace App\Application\Teacher\UseCase;

use App\Application\Teacher\Services\PeruvianPdfTextCleaner;

final class ParseSyllabusPdf
{
  private PeruvianPdfTextCleaner $textCleaner;

  public function __construct()
  {
    $this->textCleaner = new PeruvianPdfTextCleaner();
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
