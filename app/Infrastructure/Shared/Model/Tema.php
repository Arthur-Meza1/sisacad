<?php

namespace App\Infrastructure\Shared\Model;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public $timestamps = false;

    protected $fillable = ['titulo', 'orden'];

    public function curso() {
        return $this->belongsTo(Curso::class);
    }
}
