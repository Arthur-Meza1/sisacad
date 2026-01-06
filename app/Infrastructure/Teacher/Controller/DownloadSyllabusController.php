<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

readonly class DownloadSyllabusController
{
  public function __invoke($grupo): \Symfony\Component\HttpFoundation\StreamedResponse|RedirectResponse
  {
    $result = $this->findLatestSyllabus($grupo);

    return $result['error']
      ? back()->with('error', $result['message'])
      : Storage::download($result['file']);
  }

  private function findLatestSyllabus($grupo): array
  {
    $dir = "public/silabos/{$grupo}";

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
