<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\LibretaDescargar;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class LibretaDescargarController
{
  public function __construct(
    private LibretaDescargar $libretaDescargar
  )
  {
  }

  public function __invoke(): BinaryFileResponse
  {
    $path = $this->libretaDescargar->execute();
    abort_unless(file_exists($path), 404);
    return response()->download($path, 'libreta.xlsx');
  }
}
