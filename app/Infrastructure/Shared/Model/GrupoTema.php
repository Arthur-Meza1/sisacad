<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoTema extends Model
{
  protected $table = 'grupo_tema';
  protected $fillable = [
    'grupo_id',
    'tema_id',
    'enseñado',
    'fecha_enseñado',
    'notas'
  ];
  public $timestamps = true;

}
