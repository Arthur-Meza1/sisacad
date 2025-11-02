<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\GrupoCurso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matricula>
 */
class MatriculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::factory(),
            'grupo_curso_id' => GrupoCurso::factory(),
        ];
    }
}
