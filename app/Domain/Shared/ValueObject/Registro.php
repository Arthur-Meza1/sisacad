<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

class Registro
{
  public function __construct(
    private readonly Id $id,
    private NotasParcial $parcial,
    private NotasContinua $continua
  ) {}

  public function id(): Id {
    return $this->id;
  }

  public function parcial(): NotasParcial {
    return $this->parcial;
  }

  public function continua(): NotasContinua {
    return $this->continua;
  }
}
