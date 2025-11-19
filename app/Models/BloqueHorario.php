<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* TODO: 18/11/2025
   [X] Necesitamos unir horarios y sesiones.
   [X] Que no haya overlapping en la creación del horario FrontEnd para simplemente crear la sesión sin verificar en Backend.
   [X] Al momento de cargar la información retornar solo las aulas disponibles en ese momento.
   [X] Y al hacer click, manejar la creación de sesiones y la asistencia.

   [ ] Manejar el frontend, al crear sesion se tiene que volver a cargar todo el horario?????
*/

class BloqueHorario extends Model
{
    public $timestamps = false;

    protected $fillable = [
      'dia', 'horaInicio', 'horaFin',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class);
    }

    public function grupoCurso() {
      return $this->belongsTo(GrupoCurso::class);
    }
}
