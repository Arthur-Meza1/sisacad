<?php

namespace App\Infrastructure\Shared\Model;

use App\Infrastructure\Student\Model\Alumno;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = ['parcial1', 'parcial2', 'parcial3', 'continua1', 'continua2', 'continua3', 'sustitutorio',
        'alumno_id',
        'grupo_curso_id',
    ];

    public $timestamps = false;

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function grupoCurso()
    {
        return $this->belongsTo(GrupoCurso::class);
    }
}
