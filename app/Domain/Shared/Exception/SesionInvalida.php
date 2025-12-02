<?php

namespace App\Domain\Shared\Exception;

class SesionInvalida extends \Exception
{
  public static function execute(): self {
    return new self("Sesión invalida");
  }
}
