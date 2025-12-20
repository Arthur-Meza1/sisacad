<?php

namespace App\Domain\Admin\Repository;

use App\Application\Admin\DTOs\UserManagementDTO;
use App\Application\Admin\DTOs\NewUserDTO;
use App\Domain\Shared\ValueObject\Id;

interface IUserRepository
{
  /**
   * @return UserManagementDTO[]
   */
  public function all(): array;
  public function search(string $query): array;
  public function save(NewUserDTO $dto): Id;
}

