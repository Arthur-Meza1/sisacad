<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueHorario extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'dia', 'horaInicio', 'horaFin',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class);
    }

    public function grupoCurso() {
      return $this->belongsTo(GrupoCurso::class);
    }
}
