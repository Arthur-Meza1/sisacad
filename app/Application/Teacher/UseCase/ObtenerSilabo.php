<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\ValueObject\Id;
use Illuminate\Support\Facades\Storage;

class ObtenerSilabo
{
  public function execute(Id $cursoId): array
  {
    $dir = "public/silabos/{$cursoId->getValue()}";

    $validationResult = $this->validateDirectory($dir);
    if ($validationResult['error']) {
      return $validationResult;
    }

    $latestFile = $this->getLatestFile($validationResult['files']);

    return $latestFile
      ? ['error' => false, 'file' => $latestFile]
      : ['error' => true, 'message' => 'No se pudo localizar el archivo.'];
  }

  private function validateDirectory(string $dir): array
  {
    if (!Storage::exists($dir)) {
      return ['error' => true, 'message' => 'No se encontró sílabo para este grupo.'];
    }

    $files = Storage::files($dir);
    if (empty($files)) {
      return ['error' => true, 'message' => 'No se encontró sílabo para este grupo.'];
    }

    return ['error' => false, 'files' => $files];
  }

  private function getLatestFile(array $files): ?string
  {
    $latest = null;
    $latestTime = 0;

    foreach ($files as $file) {
      $modifiedTime = Storage::lastModified($file);

      if ($modifiedTime > $latestTime) {
        $latestTime = $modifiedTime;
        $latest = $file;
      }
    }

    return $latest;
  }
}
