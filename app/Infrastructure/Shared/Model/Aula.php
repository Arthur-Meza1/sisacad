<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    public $timestamps = false;

    protected $fillable = ['tipo', 'nombre'];

    public function bloqueHorario() {
      return $this->hasOne(BloqueHorario::class);
    }
}
