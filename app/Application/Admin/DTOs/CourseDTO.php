<?php

namespace App\Application\Admin\DTOs;

use App\Domain\Shared\ValueObject\Id;

final readonly class CourseDTO
{
  /**
   * @param TemaDTO[] $temas
   */
  public function __construct(
    public Id     $id,
    public string $nombre,

    // derivados / relaciones
    public int    $temasCount = 0,
    public array  $temas = [],
    public array  $grupos = [],
  )
  {
  }
}
