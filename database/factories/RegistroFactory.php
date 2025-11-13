<?php

namespace Database\Factories;

use App\Models\Registro;
use App\Models\Alumno;
use App\Models\GrupoCurso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registro>
 */
class RegistroFactory extends Factory
{
  protected $model = Registro::class;

  public function definition(): array
  {
    return [
      'alumno_id' => Alumno::factory(),
      'grupo_curso_id' => GrupoCurso::factory(),
      'parcial1' => $this->faker->numberBetween(0, 20),
      'parcial2' => $this->faker->numberBetween(0, 20),
      'parcial3' => $this->faker->numberBetween(0, 20),
      'continua1' => $this->faker->numberBetween(0, 20),
      'continua2' => $this->faker->numberBetween(0, 20),
      'continua3' => $this->faker->numberBetween(0, 20),
      'sustitutorio' => null,
    ];
  }
}
