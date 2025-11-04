<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    public $timestamps = false;
    protected $fillable = ['presente'];

    public function sesion() {
      return $this->belongsTo(Sesion::class);
    }

    public function alumno() {
      return $this->belongsTo(Alumno::class);
    }
}
