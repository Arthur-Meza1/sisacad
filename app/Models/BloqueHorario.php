<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueHorario extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function grupoCurso() {
        return $this->hasOne(GrupoCurso::class);
    }

    public function dias() {
        return $this->hasMany(BloqueHorarioDia::class);
    }
}
