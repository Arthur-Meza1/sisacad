<?php

namespace App\Domain\Admin\Repository;

interface ICourseRepository
{
  public function all(): array;
  public function search(string $query): array;
}
