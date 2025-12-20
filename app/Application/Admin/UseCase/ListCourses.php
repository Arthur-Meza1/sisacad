<?php

namespace App\Application\Admin\UseCase;

use App\Domain\Admin\Repository\ICourseRepository;

readonly class ListCourses
{
  public function __construct(
    private ICourseRepository $cursos
  )
  {
  }

  public function execute(): array
  {
    return $this->cursos->all();
  }
}
