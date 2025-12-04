<?php

namespace App\Application\Admin\DTOs;

use App\Domain\Shared\ValueObject\Id;

/**
 * DTO (Data Transfer Object) para transferir información de usuarios
 * entre el Repositorio de Infraestructura y el Caso de Uso de Aplicación.
 */
final readonly class UserManagementDTO
{
  public function __construct(
    public Id      $id,
    public string  $name,
    public string  $email,
    public string  $role,
  ) {}

  public static function create(
    Id $id,
    string $name,
    string $email,
    string $role,
  ): self {
    return new self($id, $name, $email, $role);
  }
}
