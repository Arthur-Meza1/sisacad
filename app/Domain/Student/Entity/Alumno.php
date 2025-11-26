<?php

namespace App\Domain\Student\Entity;

use App\Domain\Shared\ValueObject\Id;

class Alumno {
  private function __construct(
    private readonly Id $userId,
    private readonly array $grupoIds,
  ) {
  }

  public static function fromPrimitive(mixed $value): self {
    return new self(
      userId: Id::fromInt($value->id),
      grupoIds: $value->grupoIds
    );
  }

  public function getGruposId(): array {
    return $this->gruposId;
  }

  public function getUserId(): Id {
    return $this->userId;
  }
}
