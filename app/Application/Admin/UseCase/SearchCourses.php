<?php

namespace App\Application\Admin\UseCase;

use App\Domain\Admin\Repository\ICourseRepository;

readonly class SearchCourses
{
  public function __construct(
    private ICourseRepository $cursos
  )
  {
  }

  public function execute(string $query): array
  {
    return $this->cursos->search($query);
  }
}
