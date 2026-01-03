<?php

namespace App\Infrastructure\Teacher\Controller;

use App\Application\Teacher\UseCase\GetNotas;
use App\Domain\Shared\ValueObject\Id;

readonly class GetNotasController
{
  public function __construct(
    private GetNotas $getNotas
  ) {}
  public function __invoke(int $grupoId) {
    return response(
      $this->getNotas->execute(Id::fromInt($grupoId))
    );
  }
}
