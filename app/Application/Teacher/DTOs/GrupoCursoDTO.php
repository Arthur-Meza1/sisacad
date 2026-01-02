<?php

namespace App\Application\Teacher\DTOs;

use App\Domain\Shared\ValueObject\Id;

class GrupoCursoDTO
{
    public function __construct(
        public readonly Id $id,
        public readonly string $nombre,
        public readonly string $turno,
        public readonly string $tipo,
        public readonly int $nregistros,
    ) {}
}
