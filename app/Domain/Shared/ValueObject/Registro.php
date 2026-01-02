<?php

namespace App\Domain\Shared\ValueObject;

class Registro
{
    public function __construct(
        private readonly Id $id,
        private NotasParcial $parcial,
        private NotasContinua $continua
    ) {}

    public function id(): Id
    {
        return $this->id;
    }

    public function parcial(): NotasParcial
    {
        return $this->parcial;
    }

    public function continua(): NotasContinua
    {
        return $this->continua;
    }

    public function update(array $notas): void
    {
        if (array_key_exists('parcial1', $notas)) {
            $this->parcial->setUnidad1($notas['parcial1']);
        }
        if (array_key_exists('parcial2', $notas)) {
            $this->parcial->setUnidad2($notas['parcial2']);
        }
        if (array_key_exists('parcial3', $notas)) {
            $this->parcial->setUnidad3($notas['parcial3']);
        }
        if (array_key_exists('sustitutorio', $notas)) {
            $this->parcial->setSustitutorio($notas['sustitutorio']);
        }

        if (array_key_exists('continua1', $notas)) {
            $this->continua->setUnidad1($notas['continua1']);
        }
        if (array_key_exists('continua2', $notas)) {
            $this->continua->setUnidad2($notas['continua2']);
        }
        if (array_key_exists('continua3', $notas)) {
            $this->continua->setUnidad3($notas['continua3']);
        }
    }
}
