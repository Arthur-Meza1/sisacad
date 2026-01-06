<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Capitulo extends Model
{
  use HasFactory;

  protected $table = 'capitulos';

  protected $fillable = [
    'curso_id',
    'unidad_id',
    'nombre',
    'orden',
  ];

  public function curso()
  {
    return $this->belongsTo(Curso::class);
  }

  public function unidad()
  {
    return $this->belongsTo(Unidad::class);
  }

  public function temas()
  {
    return $this->hasMany(Tema::class);
  }
}
