<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
  public $timestamps = false;
  protected $fillable = ['grupo_curso_id', 'fecha', 'horaInicio', 'horaFin'];

  public function grupoCurso()
  {
    return $this->belongsTo(GrupoCurso::class);
  }

  public function asistencias()
  {
    return $this->hasMany(Asistencia::class);
  }
}
