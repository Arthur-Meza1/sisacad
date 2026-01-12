<?php

namespace Database\Seeders;

use App\Infrastructure\Shared\Model\Aula;
use App\Infrastructure\Shared\Model\Matricula;
use App\Infrastructure\Shared\Model\Registro;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Infrastructure\Shared\Model\BloqueHorario;
use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\User;
use App\Infrastructure\Student\Model\Alumno;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
  public function run()
  {
    $raw = file_get_contents(database_path('data/alumnos.txt'));

    // Split by blank lines
    $blocks = preg_split("/\n\s*\n/", trim($raw));

    foreach ($blocks as $block) {
      $lines = array_values(array_filter(
        array_map('trim', explode("\n", $block))
      ));

      if (count($lines) < 2) {
        continue;
      }

      // 1️⃣ Student name
      $studentName = array_shift($lines);

      // 2️⃣ Create user
      $user = User::firstOrCreate(
        ['email' => $this->emailFromName($studentName)],
        [
          'name' => $studentName,
          'password' => bcrypt('password'),
          'role' => 'student',
        ]
      );

      // 3️⃣ Create student
      $student = Alumno::firstOrCreate([
        'user_id' => $user->id
      ]);

      // 4️⃣ Courses
      foreach ($lines as $line) {
        // Extract turno (last token)
        [$courseName, $turno] = [
          trim(substr($line, 0, -1)),
          substr($line, -1),
        ];

        $curso = Curso::whereRaw(
          'UPPER(nombre) = ?',
          [$courseName]
        )->first();

        if (!$curso) {
          logger()->warning("Curso not found: {$courseName}");
          continue;
        }

        $grupo = GrupoCurso::where('curso_id', $curso->id)
          ->where('turno', $turno)->where('tipo', 'teoria')
          ->first();

        if (!$grupo) {
          logger()->warning("Grupo not found: {$courseName} {$turno}");
          continue;
        }

        Registro::factory()->create([
          'alumno_id' => $student->id,
          'grupo_curso_id' => $grupo->id,
        ]);

        Matricula::create([
          'alumno_id' => $student->id,
          'grupo_curso_id' => $grupo->id,
        ]);

        // 5️⃣ Enroll student
        $grupo->alumnos()->syncWithoutDetaching([
          $student->id
        ]);
      }
    }
  }

  private function emailFromName(string $name): string
  {
    $slug = Str::slug($name, '.');
    return $slug . '@unsa.edu.pe';
  }
}


