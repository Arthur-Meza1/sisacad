<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function matriculas() {
        return $this->hasMany(Matricula::class);
    }

    public function grupos() {
        return $this->belongsToMany(GrupoCurso::class, 'matriculas');
    }

    public function registros() {
        return $this->hasMany(Registro::class);
    }
}
