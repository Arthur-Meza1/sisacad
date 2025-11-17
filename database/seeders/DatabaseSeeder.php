<?php
namespace Database\Seeders;

use App\Models\Aula;
use App\Models\BloqueHorario;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\GrupoCurso;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run() {
      $this->call(
        TestSeeder::class,
      );
    }
}
