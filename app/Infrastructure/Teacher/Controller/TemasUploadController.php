<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

readonly class TemasUploadController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'tema' => 'required|file|mimes:pdf,doc,docx,zip,txt|max:10240',
            'grupo' => 'required|integer',
        ]);

        $grupo = $request->input('grupo');
        $file = $request->file('tema');
        $original = $file->getClientOriginalName();
        $filename = time() . '' . preg_replace('/[^A-Za-z0-9.-]/', '_', $original);
        $content = base64_encode(file_get_contents($file->getRealPath()));
        $mime = $file->getClientMimeType();
        $size = $file->getSize();

        $entry = [
            'name' => $filename,
            'original_name' => $original,
            'content' => $content,
            'mime' => $mime,
            'size' => $size,
            'uploaded_at' => time(),
        ];

        $sessionKey = "temas.{$grupo}";
        $arr = Session::get($sessionKey, []);
        $arr[] = $entry;
        Session::put($sessionKey, $arr);

        return redirect()->route('teacher.temas.index', ['grupo' => $grupo])->with('success', 'Tema subido correctamente (temporal en sesión).');
    }
}