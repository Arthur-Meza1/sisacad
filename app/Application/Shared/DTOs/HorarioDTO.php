<?php

namespace App\Application\Shared\DTOs;

class HorarioDTO {
  /**
   * @param BloqueHorarioDTO[] $horario
   * @param BloqueHorarioDTO[] $sesiones
   * @param OtherHorarioDTO[] $otros
   */
  public function __construct(
    public array $horario,
    public array $sesiones,
    public array $otros,
  ) {
  }
}
