<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;

interface IRegistroRepository
{
    public function getOrCreateByAlumnoInGrupo(Id $alumnoId, Id $grupoId): Registro;

    public function getById(Id $id): Registro;

    public function save(Registro $registro): void;
}
