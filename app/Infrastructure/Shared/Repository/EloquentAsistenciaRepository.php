<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Entity\Asistencia;
use App\Domain\Shared\Repository\IAsistenciaRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Asistencia as EloquentAsistencia;

class EloquentAsistenciaRepository implements IAsistenciaRepository {
  public function getBySesionId(Id $id): array {
    return
      EloquentAsistencia::with('alumno.user')
        ->where('sesion_id', $id->getValue())
        ->get()
        ->map(fn (EloquentAsistencia $asistencia) =>
          Asistencia::create(
            sesionId: Id::fromInt($asistencia->sesion_id),
            alumnoId: Id::fromInt($asistencia->alumno_id),
            alumnoNombre: $asistencia->alumno->user->name,
            status: $asistencia->presente,
          )
        )->all();
  }

  public function save(Asistencia $asistencia): Asistencia {
    EloquentAsistencia::create([
      'presente' => $asistencia->isPresente(),
      'alumno_id' => $asistencia->alumnoId->getValue(),
      'sesion_id' => $asistencia->sesionId->getValue(),
    ]);

    return $asistencia;
  }
}
