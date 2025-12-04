<?php

namespace App\Application\Admin\UseCase;

use App\Domain\Admin\Repository\IUserRepository;
use App\Application\Admin\DTOs\NewUserDTO;
use App\Domain\Shared\ValueObject\Id;

final readonly class CreateNewUserCommand
{
  public function __construct(
    private IUserRepository $userRepository
  ) {}

  public function handle(NewUserDTO $dto): Id
  {
    if (!in_array($dto->role, ['admin', 'teacher', 'student'])) {
      throw new \InvalidArgumentException("Role '{$dto->role}' no válido.");
    }

    return $this->userRepository->save($dto);
  }
}
