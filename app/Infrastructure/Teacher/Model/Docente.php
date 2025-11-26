<?php

namespace App\Infrastructure\Teacher\Model;

use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\User;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function grupos() {
        return $this->hasMany(GrupoCurso::class);
    }
}
