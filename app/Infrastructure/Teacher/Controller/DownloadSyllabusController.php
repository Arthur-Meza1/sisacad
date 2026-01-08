<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\ObtenerSilabo;
use App\Domain\Shared\ValueObject\Id;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

readonly class DownloadSyllabusController
{
  public function __construct(
    private ObtenerSilabo $obtenerSilabo,
  ) {}
  public function __invoke(int $cursoId): \Symfony\Component\HttpFoundation\StreamedResponse|RedirectResponse
  {
    $result = $this->obtenerSilabo->execute(Id::fromInt($cursoId));

    return $result['error']
      ? back()->with('error', $result['message'])
      : Storage::download($result['file']);
  }
}
