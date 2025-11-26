<?php

namespace App\Domain\Shared\Exception;

class InvalidDia extends \Exception {
  public static function execute(string $dia): self {
    return new self("Dia invalido: {$dia}");
  }
}
