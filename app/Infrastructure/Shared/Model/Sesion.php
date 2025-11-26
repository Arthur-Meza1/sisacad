<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
  public $timestamps = false;
  protected $fillable = ['grupo_curso_id', 'aula_id', 'fecha', 'horaInicio', 'horaFin'];

  protected $hidden = ['grupo_curso_id', 'aula_id'];

  public function grupoCurso()
  {
    return $this->belongsTo(GrupoCurso::class);
  }

  public function aula() {
    return $this->belongsTo(Aula::class);
  }

  public function asistencias()
  {
    return $this->hasMany(Asistencia::class);
  }
}
