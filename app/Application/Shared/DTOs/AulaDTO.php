<?php

namespace App\Application\Shared\DTOs;

use App\Domain\Shared\ValueObject\Id;

class AulaDTO
{
    public function __construct(
        public readonly Id $id,
        public readonly string $nombre,
    ) {}
}
