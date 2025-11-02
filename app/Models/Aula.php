<?php

namespace App\Models;

use App\Enums\AulaTipo;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    public $timestamps = false;

    protected $fillable = ['tipo', 'nombre'];

    protected $casts = [
        'tipo' => AulaTipo::class,
    ];

    public function bloqueHorario() {
      return $this->hasOne(BloqueHorario::class);
    }
}
