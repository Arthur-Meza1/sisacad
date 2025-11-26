<?php

namespace App\Domain\Shared\Repository;

use App\Application\Shared\DTOs\BloqueHorarioDTO;
use App\Application\Shared\DTOs\HorarioDTO;

interface IHorarioRepository {
  /**
   * @param array $grupoIds
   * @return BloqueHorarioDTO
   */
  public function getOwnHorario(array $grupoIds): HorarioDTO;

  public function getOwnHorarioAndOthers(array $grupoIds): HorarioDTO;
}
