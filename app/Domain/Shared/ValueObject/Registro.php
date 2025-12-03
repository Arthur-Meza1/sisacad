<?php

namespace App\Domain\Shared\ValueObject;

class Registro
{
  public function __construct(
    private Id $grupoId,
    private NotasParcial $parcial,
    private NotasContinua $continua
  ) {}

  public function parcial(): NotasParcial {
    return $this->parcial;
  }

  public function continua(): NotasContinua {
    return $this->continua;
  }
}
