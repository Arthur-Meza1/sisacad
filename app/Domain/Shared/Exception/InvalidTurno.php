<?php

namespace App\Domain\Shared\Exception;

class InvalidTurno extends \Exception {
  public static function execute(string $turno): self {
    return new self("Turno invalido: {$turno}");
  }
}
