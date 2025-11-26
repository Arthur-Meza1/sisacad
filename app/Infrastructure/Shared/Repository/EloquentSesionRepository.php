<?php

namespace App\Infrastructure\Shared\Repository;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Entity\Sesion;
use App\Domain\Shared\Exception\SesionNotFound;
use App\Domain\Shared\Repository\ISesionRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentSesionRepository implements ISesionRepository {
  public function findOrFail(SesionDTO $sesionDTO): Sesion {
    try {
      $sesion = EloquentSesion::query()
        ->where('fecha', $sesionDTO->fecha->getValue())
        ->where('grupo_curso_id', $sesionDTO->grupoId->getValue())
        ->where('aula_id', $sesionDTO->aulaId->getValue())
        ->where(function($query) use ($sesionDTO) {
          // Superposición de rangos
          $query->where(function($q) use ($sesionDTO) {
            $q->where('horaInicio', '<=', $sesionDTO->horaInicio->getValue())
              ->where('horaFin', '>=', $sesionDTO->horaInicio->getValue());
          })
            ->orWhere(function($q) use ($sesionDTO) {
              $q->where('horaInicio', '<=', $sesionDTO->horaFin->getValue())
                ->where('horaFin', '>=', $sesionDTO->horaFin->getValue());
            });
        })
        ->firstOrFail();

      // Reconstruir DTO desde el modelo Eloquent
      return Sesion::create(
        id: Id::fromInt($sesion->id),
        dto: $sesionDTO
      );
    } catch (ModelNotFoundException) {
      throw SesionNotFound::execute();
    }
  }

  public function save(SesionDTO $dto): Sesion {
    $sesion = EloquentSesion::create([
      'grupo_curso_id' => $dto->grupoId->getValue(),
      'aula_id' => $dto->aulaId->getValue(),
      'fecha' => $dto->fecha->getValue(),
      'horaInicio' => $dto->horaInicio->getValue(),
      'horaFin' => $dto->horaFin->getValue(),
    ]);

    return Sesion::create(
      id: Id::fromInt($sesion->id),
      dto: $dto
    );
  }
}
