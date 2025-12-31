<?php

namespace Tests\Domain\Shared\Entity;

use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Carbon\Carbon;
use App\Domain\Shared\Entity\Sesion;
use PHPUnit\Framework\TestCase;

class SesionTest extends TestCase
{
  private Sesion $sesion;
  protected function setUp(): void
  {
    parent::setUp();

    $this->sesion = Sesion::fromPrimitives(Id::fromInt(0), Fecha::fromString("2025-12-19"), Hora::fromString("08:00"));
  }

  public function testAntesDeSesion() {
    Carbon::setTestNow(Carbon::parse("2025-12-19 07:59"));

    $result = $this->sesion->editable();

    $this->assertFalse($result);
  }

  public function testInicioDeSesion() {
    Carbon::setTestNow(Carbon::parse("2025-12-19 08:00"));

    $result = $this->sesion->editable();

    $this->assertTrue($result);
  }

  public function testInicioDeSesionDiferenteFecha() {
    Carbon::setTestNow(Carbon::parse("2025-12-20 08:00"));

    $result = $this->sesion->editable();

    $this->assertFalse($result);
  }

  public function testDuranteSesion() {
    Carbon::setTestNow(Carbon::parse("2025-12-19 08:15"));

    $result = $this->sesion->editable();

    $this->assertTrue($result);
  }

  public function testDuranteSesionDiferenteFecha() {
    Carbon::setTestNow(Carbon::parse("2025-12-18 08:15"));

    $result = $this->sesion->editable();

    $this->assertFalse($result);
  }

  public function testDespuesDeSesion() {
    Carbon::setTestNow(Carbon::parse("2025-12-19 08:16"));

    $result = $this->sesion->editable();

    $this->assertFalse($result);
  }
}
