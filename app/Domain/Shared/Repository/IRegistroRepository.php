<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;
use App\Domain\Student\Entity\Alumno;

interface IRegistroRepository
{
  public function getOrCreateByAlumnoInGrupo(Id $alumnoId, Id $grupoId): Registro;

  // public function update(Alumno $alumno, Id $grupoId): void;
}
