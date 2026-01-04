<?php

namespace App\Infrastructure\Teacher\Controller;

use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

readonly class TemasIndexController
{
    public function __invoke($grupo): View
    {
        $sessionKey = "temas.{$grupo}";
        $files = Session::get($sessionKey, []);

        return view('teacher.temas.index', compact('grupo', 'files'));
    }
}