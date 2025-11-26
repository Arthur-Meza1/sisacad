<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class Id {
  private function __construct(
    private readonly int $value
  ) {
    if($value < 0) {
      throw InvalidValue::intNegative($value);
    }
  }

  /**
   * @param int $value
   * @return self
   * @throws InvalidValue
   */
  public static function fromInt(int $value): self {
    return new self($value);
  }

  public function getValue(): int {
    return $this->value;
  }
}
