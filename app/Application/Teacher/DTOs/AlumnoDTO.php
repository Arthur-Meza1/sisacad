<?php

namespace App\Application\Teacher\DTOs;

use App\Domain\Shared\ValueObject\Id;

class AlumnoDTO
{
    public function __construct(
        public readonly Id $id,
        public readonly string $nombre,
    ) {}
}
