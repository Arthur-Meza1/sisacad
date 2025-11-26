<?php

namespace App\Models;

use App\Infrastructure\Shared\Model\Sesion;
use App\Infrastructure\Student\Model\Alumno;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    public $timestamps = false;
    protected $fillable = ['presente',
      'alumno_id',
      'sesion_id'
    ];

    public function sesion() {
      return $this->belongsTo(Sesion::class);
    }

    public function alumno() {
      return $this->belongsTo(Alumno::class);
    }
}
