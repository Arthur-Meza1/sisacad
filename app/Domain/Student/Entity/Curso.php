<?php

namespace App\Domain\Student\Entity;

use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\Id;

class Curso {
  /**
   * @param Id $id
   * @param string $nombre
   * @throws InvalidValue
   */
  public function __construct(
    private readonly Id $id,
    private readonly string $nombre,
  ) {
    if(empty($nombre)) {
      throw InvalidValue::stringNullOrEmpty();
    }
  }

  public function id(): Id {
    return $this->id;
  }

  public function nombre(): string {
    return $this->nombre;
  }
}
