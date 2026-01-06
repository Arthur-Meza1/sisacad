<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
  public $timestamps = false;
  protected $fillable = ['capitulo_id', 'titulo', 'orden'];

  public function capitulo() {
    return $this->belongsTo(Capitulo::class);
  }
}
