<?php

namespace App\Domain\Teacher\Entity;

use App\Domain\Shared\Entity\User;
use App\Domain\Shared\ValueObject\Id;

class Docente {
  private function __construct(
    private readonly Id $userId,
    private array $grupoIds,
  ) {}

  public static function fromPrimitive(mixed $value): self {
    return new self(
      userId: Id::fromInt($value->id),
      grupoIds: $value->grupoIds
    );
  }

  public function getGruposId(): array {
    return $this->grupoIds;
  }
}
