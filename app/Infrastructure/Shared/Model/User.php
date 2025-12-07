<?php

namespace App\Infrastructure\Shared\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Infrastructure\Student\Model\Alumno;
use App\Infrastructure\Teacher\Model\Docente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property-read \App\Infrastructure\Student\Model\Alumno|null $alumno
 * @property-read \App\Infrastructure\Teacher\Model\Docente|null $docente
 * /
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

  protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function docente() {
        return $this->hasOne(Docente::class);
    }

    public function alumno()
    {
      return $this->hasOne(Alumno::class);
    }
}
