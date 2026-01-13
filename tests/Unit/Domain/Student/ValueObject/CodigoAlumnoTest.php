<?php
namespace Tests\Unit\Domain\Student\ValueObject;
use PHPUnit\Framework\TestCase;
use App\Domain\Student\ValueObject\CodigoAlumno;

class CodigoAlumnoTest extends TestCase
{
  /** @test */
  public function no_permite_codigo_vacio()
  {
    $this->expectException(\InvalidArgumentException::class);

    new CodigoAlumno('');
  }
}
