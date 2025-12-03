<?php

namespace App\Infrastructure\Student\Parser;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\NotasContinua;
use App\Domain\Shared\ValueObject\NotasParcial;
use App\Domain\Shared\ValueObject\Registro;
use App\Infrastructure\Shared\Model\Registro as EloquentRegistro;

class ParseRegistroToDomain
{
  public static function fromEloquent(EloquentRegistro $eloquentRegistro): Registro{
    return new Registro(
      grupoId: Id::fromInt($eloquentRegistro->grupo_curso_id),
      parcial: new NotasParcial(
        $eloquentRegistro->parcial1,
        $eloquentRegistro->parcial2,
        $eloquentRegistro->parcial3,
        $eloquentRegistro->sustitutorio,
      ),
      continua: new NotasContinua(
        $eloquentRegistro->continua1,
        $eloquentRegistro->continua2,
        $eloquentRegistro->continua3,
      )
    );
  }
}
