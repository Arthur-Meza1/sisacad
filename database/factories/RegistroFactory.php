<?php

namespace Database\Factories;

use App\Models\GrupoCurso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registro>
 */
class RegistroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'grupo_curso_id' => GrupoCurso::factory()->create()->id,
            'parcial1' => $this->faker->optional()->numberBetween(1, 20),
            'parcial2' => $this->faker->optional()->numberBetween(1, 20),
            'parcial3' => $this->faker->optional()->numberBetween(1, 20),
            'continua1' => $this->faker->optional()->numberBetween(1, 20),
            'continua2' => $this->faker->optional()->numberBetween(1, 20),
            'continua3' => $this->faker->optional()->numberBetween(1, 20),
            'sustitutorio' => $this->faker->optional()->numberBetween(1, 20),
        ];
    }
}
