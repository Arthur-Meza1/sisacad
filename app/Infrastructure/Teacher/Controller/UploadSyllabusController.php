<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

readonly class UploadSyllabusController
{
    public function __invoke(Request $request): RedirectResponse
    {
        $request->validate([
            'silabo' => 'required|file|mimes:pdf,doc,docx|max:10240',
            'grupo' => 'required|integer',
        ]);

        $grupoId = $request->input('grupo');
        $file = $request->file('silabo');
        $filename = time() . '' . preg_replace('/[^A-Za-z0-9.-]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs("public/silabos/{$grupoId}", $filename);

        if (!$path) {
            return back()->with('error', 'Error al subir el sílabo. Intente nuevamente.');
        }

        return back()->with('success', 'Sílabo subido correctamente.');
    }
}