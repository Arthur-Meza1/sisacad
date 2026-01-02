<?php

namespace App\Domain\Shared\ValueObject;

class NotasParcial
{
    public function __construct(
        // private readonly int $porcentaje?
        private ?int $unidad1,
        private ?int $unidad2,
        private ?int $unidad3,
        private ?int $sustitutorio,
    ) {}

    public function setUnidad1(?int $unidad1): void
    {
        $this->unidad1 = $unidad1;
    }

    public function setUnidad2(?int $unidad2): void
    {
        $this->unidad2 = $unidad2;
    }

    public function setUnidad3(?int $unidad3): void
    {
        $this->unidad3 = $unidad3;
    }

    public function setSustitutorio(?int $sustitutorio): void
    {
        $this->sustitutorio = $sustitutorio;
    }

    public function unidad1(): ?int
    {
        return $this->unidad1;
    }

    public function unidad2(): ?int
    {
        return $this->unidad2;
    }

    public function unidad3(): ?int
    {
        return $this->unidad3;
    }

    public function sustitutorio(): ?int
    {
        return $this->sustitutorio;
    }

    public function toArray(): array
    {
        return [$this->unidad1, $this->unidad2, $this->unidad3];
    }
}
