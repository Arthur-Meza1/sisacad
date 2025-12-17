<?php

namespace App\Application\Admin\DTOs;

use App\Domain\Shared\ValueObject\Id;

final readonly class TemaDTO
{
  public function __construct(
    public Id     $id,
    public string $nombre,
  )
  {
  }
}
