<?php

namespace Database\Factories\Infrastructure\Shared\Model;

use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\Registro;
use App\Infrastructure\Student\Model\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroFactory extends Factory
{
    protected $model = Registro::class;

    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'grupo_curso_id' => GrupoCurso::factory(),
            'parcial1' => $this->faker->numberBetween(1, 20),
            'parcial2' => $this->faker->numberBetween(1, 20),
            'parcial3' => $this->faker->numberBetween(1, 20),
            'continua1' => $this->faker->numberBetween(1, 20),
            'continua2' => $this->faker->numberBetween(1, 20),
            'continua3' => $this->faker->numberBetween(1, 20),
            'sustitutorio' => null,
        ];
    }
}
