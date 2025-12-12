<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\Entity\Sesion;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;

interface ISesionRepository {
  public function findByIdOrFail(Id $id): Sesion;

  public function create(
    Fecha $fecha,
    Hora $inicio,
    Hora $fin,
    Id $grupoId,
    Id $aulaId): Sesion;
  public function update(Sesion $sesion): void;
  public function deleteOrFail(Id $id): void;
}
