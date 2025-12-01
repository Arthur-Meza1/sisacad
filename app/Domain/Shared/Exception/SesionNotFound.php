<?php

namespace App\Domain\Shared\Exception;

class SesionNotFound extends \Exception {
  public static function execute(): self {
    return new self("Sesion not found");
  }
}
