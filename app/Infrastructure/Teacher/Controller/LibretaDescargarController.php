<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\LibretaDescargar;

class LibretaDescargarController
{
  public function __construct(
    private readonly LibretaDescargar $libretaDescargar
  ) {}
  public function __invoke() {
    return response()->download($this->libretaDescargar->execute());
  }
}
