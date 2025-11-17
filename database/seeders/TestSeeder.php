<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\BloqueHorario;
use App\Models\Registro;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Docente;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Tema;
use App\Models\GrupoCurso;
use App\Models\Matricula;

class TestSeeder extends Seeder
{
  public function run(): void
  {
    // -------------------------
    // Crear 5 cursos con 5 temas cada uno
    // -------------------------
    $cursosData = [
      [
        'nombre' => 'Programación Competitiva',
        'temas' => ['Números y operaciones', 'Álgebra básica', 'Geometría plana', 'Funciones y gráficas', 'Resolución de problemas']
      ],
      [
        'nombre' => 'Ingenieria de Software II',
        'temas' => ['Cinemática', 'Dinámica', 'Trabajo y energía', 'Oscilaciones', 'Termodinámica']
      ],
      [
        'nombre' => 'Estructuras de Datos Avanzados',
        'temas' => ['Arte prehistórico', 'Arte clásico', 'Edad Media', 'Renacimiento', 'Arte contemporáneo']
      ],
      [
        'nombre' => 'Sistema Operativos',
        'temas' => ['HTML y CSS', 'JavaScript básico', 'PHP y Laravel', 'Bases de datos', 'Proyecto final']
      ],
      [
        'nombre' => 'Trabajo Interdisciplinario II',
        'temas' => ['Introducción a la química orgánica', 'Hidrocarburos', 'Grupos funcionales', 'Reacciones orgánicas', 'Polímeros y biomoléculas']
      ],
      [
        'nombre' => 'Matemática Aplicada a la Computación',
        'temas' => ['Introducción a la química orgánica', 'Hidrocarburos', 'Grupos funcionales', 'Reacciones orgánicas', 'Polímeros y biomoléculas']
      ],
    ];

    $cursos = [];
    foreach ($cursosData as $c) {
      $curso = Curso::create(['nombre' => $c['nombre']]);
      foreach ($c['temas'] as $index => $titulo) {
        Tema::create([
          'curso_id' => $curso->id,
          'titulo' => $titulo,
          'orden' => $index + 1
        ]);
      }
      $cursos[] = $curso;
    }

    $rolando = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => "Rolando",
        'email' => "rolando@example.com",
      ])->id,
    ]);

    $sarmiento = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => "sarmiento",
        'email' => "sarmiento@example.com",
      ])->id
    ]);

    $yesenia = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => "Yesenia",
        'email' => "yesenia@example.com",
      ])->id
    ]);

    $roxana = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => "Roxana",
        'email' => "roxana@example.com",
      ])->id
    ]);

    $minion = Docente::create(['user_id' =>
      User::factory()->create([
        'name' => "Minion",
        'role' => 'teacher',
        'email' => "minion@example.com",
      ])->id
    ]);

    // -------------------------
    // Crear 30 alumnos
    // -------------------------
    /* $alumnos = [];
     for ($i = 1; $i <= 30; $i++) {
       $user = User::factory()->create([
         'name' => "Alumno $i",
         'email' => "alumno$i@example.com",
       ]);
       $alumnos[] = Alumno::create(['user_id' => $user->id]);
     }*/

    // -------------------------
    // Crear GrupoCurso y asignar docentes, turnos y cursos
    // Todos tipo Teoría
    // -------------------------
    $pc_t = GrupoCurso::create([
      'curso_id' => $cursos[0]->id,
      'docente_id' => $rolando->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $mac_t = GrupoCurso::create([
      'curso_id' => $cursos[5]->id,
      'docente_id' => $minion->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $mac_l = GrupoCurso::create([
      'curso_id' => $cursos[5]->id,
      'docente_id' => $yesenia->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

    $eda_t = GrupoCurso::create([
      'curso_id' => $cursos[2]->id,
      'docente_id' => $yesenia->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $eda_l = GrupoCurso::create([
      'curso_id' => $cursos[2]->id,
      'docente_id' => $sarmiento->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

    $so_t = GrupoCurso::create([
      'curso_id' => $cursos[3]->id,
      'docente_id' => $roxana->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $so_l = GrupoCurso::create([
      'curso_id' => $cursos[3]->id,
      'docente_id' => $rolando->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

    $ti2_t = GrupoCurso::create([
      'curso_id' => $cursos[4]->id,
      'docente_id' => $yesenia->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $is2_t = GrupoCurso::create([
      'curso_id' => $cursos[1]->id,
      'docente_id' => $sarmiento->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

    $is2_l = GrupoCurso::create([
      'curso_id' => $cursos[1]->id,
      'docente_id' => $roxana->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

    // ========================
    // AULAS
    // ========================
    $aula203 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 203'
    ]);
    $lab04 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Lab 04'
    ]);
    $lab01 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Lab 01'
    ]);
    $lab02 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Lab 02'
    ]);

    // ========================
    // BLOQUES
    // ========================
    // Lunes
    BloqueHorario::create([
      'horaInicio' => '07:00:00',
      'horaFin' => '07:50:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $mac_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '07:50:00',
      'horaFin' => '08:40:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $mac_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '08:50:00',
      'horaFin' => '09:40:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $is2_l->id,
      'aula_id' => $lab04->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '09:40:00',
      'horaFin' => '10:30:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $is2_l->id,
      'aula_id' => $lab04->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '10:40:00',
      'horaFin' => '11:30:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $eda_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '11:30:00',
      'horaFin' => '12:20:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $eda_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '12:20:00',
      'horaFin' => '13:10:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $so_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '13:10:00',
      'horaFin' => '14:00:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $so_t->id,
      'aula_id' => $aula203->id,
    ]);

    // Martes
    BloqueHorario::create([
      'horaInicio' => '08:50:00',
      'horaFin' => '09:40:00',
      'dia' => 'martes',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '09:40:00',
      'horaFin' => '10:30:00',
      'dia' => 'martes',
      'grupo_curso_id' => $mac_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '10:40:00',
      'horaFin' => '11:30:00',
      'dia' => 'martes',
      'grupo_curso_id' => $mac_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '11:30:00',
      'horaFin' => '12:20:00',
      'dia' => 'martes',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '12:20:00',
      'horaFin' => '13:10:00',
      'dia' => 'martes',
      'grupo_curso_id' => $so_l->id,
      'aula_id' => $lab01->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '13:10:00',
      'horaFin' => '14:00:00',
      'dia' => 'martes',
      'grupo_curso_id' => $so_l->id,
      'aula_id' => $lab01->id,
    ]);

    // Miercoles
    BloqueHorario::create([
      'horaInicio' => '07:00:00',
      'horaFin' => '07:50:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $ti2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '07:50:00',
      'horaFin' => '08:40:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $ti2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '08:50:00',
      'horaFin' => '09:40:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $eda_l->id,
      'aula_id' => $lab01->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '09:40:00',
      'horaFin' => '10:30:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $eda_l->id,
      'aula_id' => $lab01->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '10:40:00',
      'horaFin' => '11:30:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $so_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '11:30:00',
      'horaFin' => '12:20:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $so_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '12:20:00',
      'horaFin' => '13:10:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $is2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '13:10:00',
      'horaFin' => '14:00:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $is2_t->id,
      'aula_id' => $aula203->id,
    ]);

    // Jueves
    BloqueHorario::create([
      'horaInicio' => '07:00:00',
      'horaFin' => '07:50:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '07:50:00',
      'horaFin' => '08:40:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '08:50:00',
      'horaFin' => '09:40:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $eda_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '09:40:00',
      'horaFin' => '10:30:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $eda_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '10:40:00',
      'horaFin' => '11:30:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $ti2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '11:30:00',
      'horaFin' => '12:20:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $ti2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '12:20:00',
      'horaFin' => '13:10:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $is2_t->id,
      'aula_id' => $aula203->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '13:10:00',
      'horaFin' => '14:00:00',
      'dia' => 'jueves',
      'grupo_curso_id' => $is2_t->id,
      'aula_id' => $aula203->id,
    ]);

    // Viernes
    BloqueHorario::create([
      'horaInicio' => '08:50:00',
      'horaFin' => '09:40:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $mac_l->id,
      'aula_id' => $lab02->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '09:40:00',
      'horaFin' => '10:30:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $mac_l->id,
      'aula_id' => $lab02->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '10:40:00',
      'horaFin' => '11:30:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $lab04->id,
    ]);
    BloqueHorario::create([
      'horaInicio' => '11:30:00',
      'horaFin' => '12:20:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $pc_t->id,
      'aula_id' => $lab04->id,
    ]);

    // ===========
    // ALUMNO
    // ===========
    /*$yo = Alumno::create([
      'user_id' => User::factory()->create(['name' => 'Esdras Amado Diaz Vasquez', 'email' => 'test@example.com'])->id
    ]);
    // Matricular al alumno en sus cursos
    $matriculas = [
      $mac_t->id,
      $is2_t->id,
      $eda_t->id,
      $so_t->id,
      $pc_t->id,
      $ti2_t->id,
    ];

    foreach ($matriculas as $grupoId) {
      Matricula::create([
        'alumno_id' => $yo->id,
        'grupo_curso_id' => $grupoId,
      ]);

      // Crear un registro de notas para este curso
      Registro::factory()->create([
        'alumno_id' => $yo->id,
        'grupo_curso_id' => $grupoId,
      ]);
      */
    // Cursos en los que se matricularán todos los alumnos
    $matriculas = [
      $mac_t->id,
      $is2_t->id,
      $eda_t->id,
      $so_t->id,
      $pc_t->id,
      $ti2_t->id,
    ];

// Cantidad de alumnos a crear
    $cantidadAlumnos = 5;

    for ($i = 0; $i < $cantidadAlumnos; $i++) {

      // Crear usuario y alumno
      $user = User::factory()->create();
      $alumno = Alumno::create([
        'user_id' => $user->id,
      ]);

      // Matricular al alumno en los cursos y crear registros
      foreach ($matriculas as $grupoId) {
        Matricula::create([
          'alumno_id' => $alumno->id,
          'grupo_curso_id' => $grupoId,
        ]);

        Registro::factory()->create([
          'alumno_id' => $alumno->id,
          'grupo_curso_id' => $grupoId,
        ]);
      }
    }
  }
}
