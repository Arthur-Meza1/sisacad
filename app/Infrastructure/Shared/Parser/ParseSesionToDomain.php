<?php

namespace App\Infrastructure\Shared\Parser;

use App\Domain\Shared\Entity\Sesion;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;

class ParseSesionToDomain {
  public static function fromEloquent(EloquentSesion $eloquentSesion): Sesion {
    $sesion = Sesion::fromPrimitives(
      id: Id::fromInt($eloquentSesion->id),
    );

    $eloquentSesion->asistencias->each(
      function ($asistencia) use ($sesion) {
        $sesion->registrarAsistencia(
          alumnoId: Id::fromInt($asistencia->alumno->id),
          nombre: $asistencia->alumno->user->name,
          estado: AsistenciaEstado::fromBoolean($asistencia->presente)
        );
      });

    return $sesion;
  }
}
