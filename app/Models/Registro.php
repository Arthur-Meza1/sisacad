<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $fillable = ['parcial1', 'parcial2', 'parcial3', 'continua1', 'continua2', 'continua3', 'sustitutorio',
      'alumno_id',
      'grupo_curso_id'
    ];
    public $timestamps = false;

    public function getNotasParcial() {
      $parcial1 = $this->parcial1;
      $parcial2 = $this->parcial2;
      if(($sust = $this->sustitutorio) != null) {
        if($parcial1 < $parcial2) {
          $parcial1 = $sust;
        } else {
          $parcial2 = $sust;
        }
      }

      return collect([$parcial1, $parcial2, $this->parcial3]);
    }

    public function getNotasContinua() {
      return collect([$this->continua1, $this->continua2, $this->continua3]);
    }

    public function alumno() {
        return $this->belongsTo(Alumno::class);
    }

    public function grupoCurso() {
        return $this->belongsTo(GrupoCurso::class);
    }
}
