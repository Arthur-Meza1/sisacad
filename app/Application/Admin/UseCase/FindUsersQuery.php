<?php

namespace App\Application\Admin\UseCase;

use App\Domain\Admin\Repository\IUserRepository;
use App\Application\Admin\DTOs\UserManagementDTO;

class FindUsersQuery
{
  public function __construct(private readonly IUserRepository $userRepository) {}

  /**
   * @return UserManagementDTO[]
   */
  public function execute(string $query): array
  {
    // Lógica de negocio (ej. validación de longitud de la query)
    if (strlen($query) < 3) {
      return [];
    }

    return $this->userRepository->search($query);
  }
}
