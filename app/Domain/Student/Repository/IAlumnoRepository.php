<?php

namespace App\Domain\Student\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;

interface IAlumnoRepository {
  /**
   * @param Id $id
   * @return Alumno[]
   */
  public function getByGrupoCursoId(Id $id): array;
  public function findFromIdOrFail(Id $id): Alumno;
}
