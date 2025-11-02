<?php

namespace App\Models;

use App\Enums\CursoTipo;
use App\Enums\Turno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoCurso extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['turno', 'tipo'];

    protected $casts = [
        'turno' => Turno::class,
        'tipo' => CursoTipo::class,
    ];

    public function docente() {
        return $this->belongsTo(Docente::class);
    }

    public function curso() {
        return $this->belongsTo(Curso::class);
    }

    public function matriculas() {
        return $this->hasMany(Matricula::class);
    }

    public function alumnos() {
        return $this->belongsToMany(Alumno::class, 'matriculas');
    }

    public function bloqueHorario() {
        return $this->hasMany(BloqueHorario::class);
    }

    public function registros() {
        return $this->hasMany(Registro::class);
    }
}
