<?php

namespace Database\Factories\Infrastructure\Shared\Model;

use App\Infrastructure\Shared\Model\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Shared\Model\GrupoCurso>
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
            'turno' => $this->faker->randomElement(),
            'curso_id' => Curso::factory(), // Crea un curso asociado automáticamente
            'tipo' => $this->faker->randomElement(),
        ];
    }
}
