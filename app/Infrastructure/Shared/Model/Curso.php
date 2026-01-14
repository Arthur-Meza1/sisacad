<?php

namespace App\Infrastructure\Shared\Model;

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

    public function grupoCursos() {
        return $this->hasMany(GrupoCurso::class);
    }
}
