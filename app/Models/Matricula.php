<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function grupoCurso() {
        return $this->belongsTo(GrupoCurso::class);
    }

    public function alumno() {
        return $this->belongsTo(Alumno::class);
    }
}
