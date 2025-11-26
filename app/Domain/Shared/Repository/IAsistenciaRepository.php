<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\Entity\Asistencia;
use App\Domain\Shared\ValueObject\Id;

interface IAsistenciaRepository {
  public function getBySesionId(Id $id): array;
  public function save(Asistencia $asistencia): Asistencia;
}
