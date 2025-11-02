<?php

namespace App\Models;

use App\Enums\DiaSemana;
use Illuminate\Database\Eloquent\Model;

class BloqueHorario extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'dia', 'horaInicio', 'horaFin',
    ];

    protected $casts = [
        'dia' => DiaSemana::class,
    ];

    public function aula() {
        return $this->belongsTo(Aula::class);
    }

    public function grupoCurso() {
      return $this->belongsTo(GrupoCurso::class);
    }
}
