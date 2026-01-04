<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Support\Facades\Session;

readonly class TemasDownloadController
{
    public function __invoke($grupo, $file)
    {
        $sessionKey = "temas.{$grupo}";
        $files = Session::get($sessionKey, []);
        $decodedName = urldecode($file);
        $found = null;
        foreach ($files as $f) {
            if (($f['name'] ?? '') === $decodedName || ($f['original_name'] ?? '') === $decodedName) {
                $found = $f;
                break;
            }
        }

        if (!$found) {
            return back()->with('error', 'Archivo no encontrado en la sesión.');
        }

        $content = base64_decode($found['content']);

        return response($content, 200, [
            'Content-Type' => $found['mime'] ?? 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . ($found['original_name'] ?? $found['name']) . '"',
        ]);
    }
}