<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

readonly class DownloadSyllabusController
{
    public function __invoke($grupo)
    {
        $dir = "public/silabos/{$grupo}";
        if (!Storage::exists($dir)) {
            return back()->with('error', 'No se encontró sílabo para este grupo.');
        }

        $files = Storage::files($dir);
        if (empty($files)) {
            return back()->with('error', 'No se encontró sílabo para este grupo.');
        }

        $latest = null;
        $latestTime = 0;
        foreach ($files as $f) {
            $t = Storage::lastModified($f);
            if ($t > $latestTime) {
                $latestTime = $t;
                $latest = $f;
            }
        }

        if (!$latest) {
            return back()->with('error', 'No se pudo localizar el archivo.');
        }

        return Storage::download($latest);
    }
}