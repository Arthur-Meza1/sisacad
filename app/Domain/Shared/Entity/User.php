<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\UserRol;

class User {
  protected function __construct(
    private readonly string  $nombre,
    private readonly string  $correo,
    private readonly UserRol $rol,
  ) {
  }

  public function getNombre(): string {
    return $this->nombre;
  }

  public function getCorreo(): string {
    return $this->correo;
  }

  public function getRol(): UserRol {
    return $this->rol;
  }
}
