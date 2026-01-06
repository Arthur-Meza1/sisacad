<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['nombre','creditos'];

    public function capitulos() {
    return $this->hasMany(Capitulo::class);
    }

    public function grupoCursos() {
        return $this->hasMany(GrupoCurso::class);
    }
    public function temas() {
      return $this->hasManyThrough(
        Tema::class,
        Capitulo::class,
        'curso_id',     // FK en capitulos
        'capitulo_id',  // FK en temas
        'id',           // PK en cursos
        'id'            // PK en capitulos
      );
    }
}
