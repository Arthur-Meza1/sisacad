<?php

namespace Database\Factories;

use App\Enums\CursoTipo;
use App\Enums\Turno;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GrupoCurso>
 */
class GrupoCursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'turno' => $this->faker->randomElement(Turno::cases()),
            'curso_id' => Curso::factory(), // Crea un curso asociado automáticamente
            'tipo' => $this->faker->randomElement(CursoTipo::cases()),
        ];
    }
}
