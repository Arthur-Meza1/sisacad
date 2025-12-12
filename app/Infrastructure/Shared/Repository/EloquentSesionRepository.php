<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Entity\Sesion;
use App\Domain\Shared\Exception\SesionNotFound;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Asistencia as EloquentAsistencia;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;
use App\Infrastructure\Shared\Parser\ParseSesionToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentSesionRepository implements ISesionRepository {
  /**
   * @param Fecha $fecha
   * @param Hora $inicio
   * @param Hora $fin
   * @param Id $grupoId
   * @param Id $aulaId
   * @return Sesion
   * @throws SesionNotFound
   * @throws \Exception
   */
  public function findByQueryOrFail(
    Fecha $fecha,
    Hora $inicio,
    Hora $fin,
    Id $grupoId,
    Id $aulaId
  ): Sesion {
    try {
      $eloquentSesion = EloquentSesion::query()
        ->with('asistencias.alumno.user')
        ->where('fecha', $fecha->toString())
        ->where('grupo_curso_id', $grupoId->getValue())
        ->where('aula_id', $aulaId->getValue())
        ->where(function($query) use ($inicio, $fin) {
          $query->where(function($q) use ($inicio) {
            $q->where('horaInicio', '<=', $inicio->toString())
              ->where('horaFin', '>=', $inicio->toString());
          })
            ->orWhere(function($q) use ($fin) {
              $q->where('horaInicio', '<=', $fin->toString())
                ->where('horaFin', '>=', $fin->toString());
            });
        })
        ->firstOrFail();

      return ParseSesionToDomain::fromEloquent($eloquentSesion);
    } catch (ModelNotFoundException) {
      throw SesionNotFound::execute();
    }
  }

  public function findByIdOrFail(Id $id): Sesion {
    try {
      $eloquentSesion =
        EloquentSesion::with("asistencias.alumno.user")
        ->where("id", $id->getValue())
        ->firstOrFail();

      return ParseSesionToDomain::fromEloquent($eloquentSesion);
    } catch (ModelNotFoundException) {
      throw SesionNotFound::execute();
    }
  }

  public function create(
    Fecha $fecha,
    Hora $inicio,
    Hora $fin,
    Id $grupoId,
    Id $aulaId): Sesion {
    $eloquentSesion= EloquentSesion::create([
      'grupo_curso_id' => $grupoId->getValue(),
      'aula_id' => $aulaId->getValue(),
      'fecha' => $fecha->toString(),
      'horaInicio' => $inicio->toString(),
      'horaFin' => $fin->toString(),
    ]);

    return Sesion::fromPrimitives(
      id: Id::fromInt($eloquentSesion->id),
      fecha: $fecha,
      horaInicio: $inicio,
    );
  }

  public function update(Sesion $sesion): void {
    try {
      foreach ($sesion->asistencias() as $asistencia) {
        EloquentAsistencia::updateOrCreate(
          [
            'alumno_id' => $asistencia->alumnoId()->getValue(), // value() no getValue()
            'sesion_id' => $sesion->id()->getValue(),
          ],
          [
            'presente' => $asistencia->estado()->isPresente() ? 1 : 0,
          ]
        );
      }
    } catch (ModelNotFoundException) {
      throw SesionNotFound::execute();
    }
  }
}
