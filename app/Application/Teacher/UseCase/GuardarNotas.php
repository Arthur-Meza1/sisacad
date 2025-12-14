<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Registro;

class GuardarNotas
{
  public function __construct(
    private readonly IRegistroRepository $registroRepository,
  ) {}

  /**
   * @param Registro[] $registros
   * @return void
   */
  public function execute(array $registros) {
    foreach ($registros as $registro) {
      $this->registroRepository->save($registro);
    }
  }
}
