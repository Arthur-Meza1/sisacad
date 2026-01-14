<?php

namespace App\Application\Admin\UseCase;

use App\Domain\Admin\Repository\IUserRepository;

readonly class ListUsers
{
  public function __construct(
    private IUserRepository $usuarios
  )
  {
  }

  public function execute(): array
  {
    return $this->usuarios->all();
  }
}
