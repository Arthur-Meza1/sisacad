<?php

namespace Database\Seeders;

use App\Infrastructure\Shared\Model\Aula;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Infrastructure\Shared\Model\BloqueHorario;
use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Shared\Model\GrupoCurso;
use App\Infrastructure\Shared\Model\User;
use App\Infrastructure\Teacher\Model\Docente;
use Illuminate\Support\Str;

class JsonSeeder extends Seeder
{
  public function run(): void
  {

    User::firstOrCreate(
      ['email' => 'admin@unsa.edu.pe'],
      [
        'name' => 'Administrador',
        'password' => bcrypt('admin123'),
        'role' => 'admin', // valor permitido por el CHECK
      ]
    );

    $path = database_path('data/cursos.json');

    if (!File::exists($path)) {
      throw new \RuntimeException('No se encontró database/data/cursos.json');
    }

    $cursos = json_decode(File::get($path), true);

    foreach ($cursos as $cursoData) {

      // =======================
      // CURSO
      // =======================
      $curso = Curso::firstOrCreate(
        ['id' => $cursoData['id']],
        [
          'nombre' => $cursoData['name'],
          'creditos' => $cursoData['creditos'],
        ]
      );

      foreach ($cursoData['turnos'] as $turnoData) {

        // =======================
        // DOCENTE
        // =======================
        $user = User::firstOrCreate(
          ['name' => $turnoData['docente']],
          [
            'email' => $this->emailFromName($turnoData['docente']),
            'password' => bcrypt('password'),
            'role' => 'teacher', // valor permitido por el CHECK
          ]
        );

        $docente = Docente::firstOrCreate(
          ['user_id' => $user->id]
        );

        // =======================
        // GRUPO
        // =======================
        $grupo = GrupoCurso::firstOrCreate(
          [
            'curso_id' => $curso->id,
            'turno' => $turnoData['turno'],
            'tipo' => $turnoData['tipo'],
          ],
          [
            'docente_id' => $docente->id,
          ]
        );

        $aula = Aula::firstOrCreate(
          ["nombre" => $turnoData['salon']],[
            'tipo' => $turnoData['tipo'],
          ]
        );

        // =======================
        // HORARIOS
        // =======================
        foreach ($turnoData['horario'] as $dia => $rangos) {
          foreach ($rangos as $rango) {

            // Ignorar rangos inválidos
            if (!str_contains($rango, '-')) {
              continue;
            }

            [$inicio, $fin] = array_map(
              fn($h) => $this->normalizeHour($h),
              explode('-', $rango)
            );

            if (!$inicio || !$fin) {
              continue;
            }

            BloqueHorario::create([
              'grupo_curso_id' => $grupo->id,
              'dia' => $dia,
              'horaInicio' => $inicio,
              'horaFin' => $fin,
              'aula_id' => $aula->id,
            ]);
          }
        }
      }
    }
  }

  /**
   * Normaliza horas tipo 7:00 -> 07:00
   * Devuelve null si es inválida
   */
  private function normalizeHour(string $hour): ?string
  {
    $hour = trim($hour);

    if (!preg_match('/^\d{1,2}:\d{2}$/', $hour)) {
      return null;
    }

    [$h, $m] = explode(':', $hour);

    if ((int)$h > 23 || (int)$m > 59) {
      return null;
    }

    return sprintf('%02d:%02d', $h, $m);
  }

  /**
   * Genera email estable a partir del nombre
   */
  private function emailFromName(string $name): string
  {
    $base = Str::of($name)
      ->lower()
      ->replace(',', '')
      ->replace(' ', '')
      ->replaceMatches('/[^a-z]/', '');

    return $base . '@unsa.edu.pe';
  }
}
