<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class AsistenciaEstado {
  private function __construct(
    private bool $status
  ){}

  public static function fromString(string $status): self {
    if(!in_array($status, ['0', '1'], true)) {
      throw InvalidValue::invalidBoolString($status);
    }

    return new self($status === '1');
  }

  public static function fromBoolean(bool $status): self {
    return new self($status);
  }

  public function isPresente(): bool {
    return $this->status;
  }
}
