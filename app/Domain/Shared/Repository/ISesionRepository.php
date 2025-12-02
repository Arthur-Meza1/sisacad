<?php

namespace App\Domain\Shared\Repository;

use App\Domain\Shared\Entity\Sesion;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;

interface ISesionRepository {
  /**
   * @param Fecha $fecha
   * @param Hora $inicio
   * @param Hora $fin
   * @param Id $grupoId
   * @param Id $aulaId
   * @return Sesion
   * @throws \Exception
   */
  public function findByQueryOrFail(
    Fecha $fecha,
    Hora $inicio,
    Hora $fin,
    Id $grupoId,
    Id $aulaId): Sesion;

  public function findByIdOrFail(Id $id): Sesion;

  public function create(
    Fecha $fecha,
    Hora $inicio,
    Hora $fin,
    Id $grupoId,
    Id $aulaId): Sesion;
  public function update(Sesion $sesion): void;
}
