<?php

namespace Tests\App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

// TODO: Probar que testToCarbonWithDate según la semana que estemos corresponda al dia
// Dia = lunes entonces tiene que retornar la misma semana que Fecha pero con el dia correcto
class DiaTest extends TestCase
{
  public function testToCarbonWithDate()
  {
    $dia = Dia::fromString(Dia::VIERNES);
    $fecha = Carbon::parse("2025-11-28");

    $result = $dia->toCarbonWithDate($fecha);

    $this->assertEquals("2025-11-28", $result->format("Y-m-d"));
  }

  public function testToCarbonWithDateSameDay()
  {
    $dia = Dia::fromString(Dia::LUNES);
    $fecha = Carbon::parse("2025-09-29");

    $result = $dia->toCarbonWithDate($fecha);

    $this->assertEquals("2025-09-29", $result->format("Y-m-d"));
  }

  public function testToCarbonWithDateBetweenDays()
  {
    $dia = Dia::fromString(Dia::JUEVES);
    $fecha = Carbon::parse("2025-09-29");

    $result = $dia->toCarbonWithDate($fecha);

    $this->assertEquals("2025-10-02", $result->format("Y-m-d"));
  }

  public function testToCarbonWithDateFriday()
  {
    $dia = Dia::fromString(Dia::LUNES);
    $fecha = Carbon::parse("2025-11-28");

    $result = $dia->toCarbonWithDate($fecha);

    $this->assertEquals("2025-11-24", $result->format("Y-m-d"));
  }
}
