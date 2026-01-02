<?php

namespace App\Application\Teacher\UseCase;

class LibretaDescargar
{
    public function execute()
    {
        return resource_path('templates/libreta.xlsx');
    }
}
