<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public $timestamps = false;

    protected $fillable = ['titulo', 'orden'];

    public function curso() {
        return $this->belongsTo(Curso::class);
    }
}
