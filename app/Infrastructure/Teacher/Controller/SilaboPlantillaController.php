<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\LibretaDescargar;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

readonly class SilaboPlantillaController
{
  public function __invoke(): BinaryFileResponse
  {
    $path = resource_path('templates/silabo-plantilla.pdf');
    abort_unless(file_exists($path), 404);
    return response()->download($path, 'silabo-plantilla.pdf');
  }
}
