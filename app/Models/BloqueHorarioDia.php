<?php

namespace App\Models;

use App\Enums\DiaSemana;
use Illuminate\Database\Eloquent\Model;

class BloqueHorarioDia extends Model
{
    public $timestamps = false;

    protected $casts = [
        'dia' => DiaSemana::class,
    ];

    public function aula() {
        return $this->hasOne(Aula::class);
    }
}
