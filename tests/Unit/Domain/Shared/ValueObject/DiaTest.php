<?php

namespace Tests\Unit\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Dia;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

// TODO: Probar que testToCarbonWithDate según la semana que estemos corresponda al dia
// Dia = lunes entonces tiene que retornar la misma semana que Fecha pero con el dia correcto
class DiaTest extends TestCase
{
    public function test_to_carbon_with_date()
    {
        $dia = Dia::fromString(Dia::VIERNES);
        $fecha = Carbon::parse('2025-11-28');

        $result = $dia->toCarbonWithDate($fecha);

        $this->assertEquals('2025-11-28', $result->format('Y-m-d'));
    }

    public function test_to_carbon_with_date_same_day()
    {
        $dia = Dia::fromString(Dia::LUNES);
        $fecha = Carbon::parse('2025-09-29');

        $result = $dia->toCarbonWithDate($fecha);

        $this->assertEquals('2025-09-29', $result->format('Y-m-d'));
    }

    public function test_to_carbon_with_date_between_days()
    {
        $dia = Dia::fromString(Dia::JUEVES);
        $fecha = Carbon::parse('2025-09-29');

        $result = $dia->toCarbonWithDate($fecha);

        $this->assertEquals('2025-10-02', $result->format('Y-m-d'));
    }

    public function test_to_carbon_with_date_friday()
    {
        $dia = Dia::fromString(Dia::LUNES);
        $fecha = Carbon::parse('2025-11-28');

        $result = $dia->toCarbonWithDate($fecha);

        $this->assertEquals('2025-11-24', $result->format('Y-m-d'));
    }
}
