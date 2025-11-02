<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function temas() {
        return $this->hasMany(Tema::class);
    }

    public function grupoCurso() {
        return $this->hasOne(GrupoCurso::class);
    }
}
