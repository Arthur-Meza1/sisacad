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

class FullSeeder extends Seeder
{
  public function run(): void
  {
    // Crear curso: CALCULO EN UNA VARIABLE
    $curso_1 = Curso::create(['nombre' => 'CALCULO EN UNA VARIABLE']);

// Crear docente: EDDY AUGUSTO GUTIERREZ RODRIGUEZ
    $docente_1 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'EDDY AUGUSTO GUTIERREZ RODRIGUEZ',
        'email' => 'egutierrezro@unsa.edu.pe',
      ])->id,
    ]);

// Crear aula: Aula 201 / 26.4 - 205
    $aula_1 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 201 / 26.4 - 205'
    ]);

// Crear grupo para CALCULO EN UNA VARIABLE
    $grupo_2_2 = GrupoCurso::create([
      'curso_id' => $curso_1->id,
      'docente_id' => $docente_1->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_2_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear docente: ELISEO DANIEL VELASQUEZ CONDORI
    $docente_2 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ELISEO DANIEL VELASQUEZ CONDORI',
        'email' => 'evelasquezcon@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para CALCULO EN UNA VARIABLE
    $grupo_2_2 = GrupoCurso::create([
      'curso_id' => $curso_1->id,
      'docente_id' => $docente_2->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_2_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear curso: INGLES II
    $curso_2 = Curso::create(['nombre' => 'INGLES II']);

// Crear docente: ROCIO JACOBE AGUIRRE
    $docente_3 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ROCIO JACOBE AGUIRRE',
        'email' => 'rjacobe@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para INGLES II
    $grupo_3_2 = GrupoCurso::create([
      'curso_id' => $curso_2->id,
      'docente_id' => $docente_3->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_3_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear docente: CARLOTA CRISTINA PILCO ANDIA
    $docente_4 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'CARLOTA CRISTINA PILCO ANDIA',
        'email' => 'cpilcoa@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para INGLES II
    $grupo_3_2 = GrupoCurso::create([
      'curso_id' => $curso_2->id,
      'docente_id' => $docente_4->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $grupo_3_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear curso: ESTRUCTURAS DISCRETAS II
    $curso_3 = Curso::create(['nombre' => 'ESTRUCTURAS DISCRETAS II']);

// Crear docente: WILBER ROBERTO RAMOS LOVON
    $docente_5 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'WILBER ROBERTO RAMOS LOVON',
        'email' => 'wramos@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ESTRUCTURAS DISCRETAS II
    $grupo_4_2 = GrupoCurso::create([
      'curso_id' => $curso_3->id,
      'docente_id' => $docente_5->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_4_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear grupo para ESTRUCTURAS DISCRETAS II
    $grupo_4_2 = GrupoCurso::create([
      'curso_id' => $curso_3->id,
      'docente_id' => $docente_5->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_4_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear curso: PROGRAMACION I
    $curso_4 = Curso::create(['nombre' => 'PROGRAMACION I']);

// Crear docente: ELIANA MARIA ADRIAZOLA HERRERA
    $docente_6 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ELIANA MARIA ADRIAZOLA HERRERA',
        'email' => 'eadriazola@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para PROGRAMACION I
    $grupo_5_5 = GrupoCurso::create([
      'curso_id' => $curso_4->id,
      'docente_id' => $docente_6->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '07:00',
      'horaFin' => '08:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_5_5->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear grupo para PROGRAMACION I
    $grupo_5_5 = GrupoCurso::create([
      'curso_id' => $curso_4->id,
      'docente_id' => $docente_6->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_5_5->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear aula: Laboratorio 2
    $aula_2 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Laboratorio 2'
    ]);

// Crear grupo para PROGRAMACION I
    $grupo_5_5 = GrupoCurso::create([
      'curso_id' => $curso_4->id,
      'docente_id' => $docente_6->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '11:30',
      'horaFin' => '13:10',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_5_5->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear aula: Laboratorio 1
    $aula_3 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Laboratorio 1'
    ]);

// Crear grupo para PROGRAMACION I
    $grupo_5_5 = GrupoCurso::create([
      'curso_id' => $curso_4->id,
      'docente_id' => $docente_6->id,
      'turno' => 'C',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_5_5->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear grupo para PROGRAMACION I
    $grupo_5_5 = GrupoCurso::create([
      'curso_id' => $curso_4->id,
      'docente_id' => $docente_6->id,
      'turno' => 'B',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_5_5->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear curso: REALIDAD NACIONAL
    $curso_5 = Curso::create(['nombre' => 'REALIDAD NACIONAL']);

// Crear docente: ERIKA PATRICIA LAZO ALARCON
    $docente_7 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ERIKA PATRICIA LAZO ALARCON',
        'email' => 'elazoal@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para REALIDAD NACIONAL
    $grupo_6_2 = GrupoCurso::create([
      'curso_id' => $curso_5->id,
      'docente_id' => $docente_7->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '7:00',
      'horaFin' => '9:40',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_6_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear grupo para REALIDAD NACIONAL
    $grupo_6_2 = GrupoCurso::create([
      'curso_id' => $curso_5->id,
      'docente_id' => $docente_7->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '16:40',
      'horaFin' => '19:20',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_6_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear curso: LINGUISTICA COMPRENSION Y REDACCION ACADEMICA
    $curso_6 = Curso::create(['nombre' => 'LINGUISTICA COMPRENSION Y REDACCION ACADEMICA']);

// Crear docente: NADJA CATALIN OSORIO MENDOZA DE MONTEZA
    $docente_8 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'NADJA CATALIN OSORIO MENDOZA DE MONTEZA',
        'email' => 'nosoriom@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para LINGUISTICA COMPRENSION Y REDACCION ACADEMICA
    $grupo_7_2 = GrupoCurso::create([
      'curso_id' => $curso_6->id,
      'docente_id' => $docente_8->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '9:40',
      'horaFin' => '12:20',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_7_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear docente: PILAR ELIZABETH ZEBALLOS RAMIREZ
    $docente_9 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'PILAR ELIZABETH ZEBALLOS RAMIREZ',
        'email' => 'pzeballosra@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para LINGUISTICA COMPRENSION Y REDACCION ACADEMICA
    $grupo_7_2 = GrupoCurso::create([
      'curso_id' => $curso_6->id,
      'docente_id' => $docente_9->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '16:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_7_2->id,
      'aula_id' => $aula_1->id,
    ]);

// Crear curso: ALGEBRA LINEAL NUMERICA
    $curso_7 = Curso::create(['nombre' => 'ALGEBRA LINEAL NUMERICA']);

// Crear docente: ROGER EDWAR MESTAS CHAVEZ
    $docente_10 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ROGER EDWAR MESTAS CHAVEZ',
        'email' => 'rmestasc@unsa.edu.pe',
      ])->id,
    ]);

// Crear aula: Aula 202 / 26.4 - 206
    $aula_4 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 202 / 26.4 - 206'
    ]);

// Crear grupo para ALGEBRA LINEAL NUMERICA
    $grupo_8_4 = GrupoCurso::create([
      'curso_id' => $curso_7->id,
      'docente_id' => $docente_10->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '7:00',
      'horaFin' => '8:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_8_4->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ALGEBRA LINEAL NUMERICA
    $grupo_8_4 = GrupoCurso::create([
      'curso_id' => $curso_7->id,
      'docente_id' => $docente_10->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '7:00',
      'horaFin' => '8:40',
      'dia' => 'jueves',
      'grupo_curso_id' => $grupo_8_4->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear docente: JUDID CARINA VIZA HUAYLLASO
    $docente_11 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'JUDID CARINA VIZA HUAYLLASO',
        'email' => 'jvizah@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGEBRA LINEAL NUMERICA
    $grupo_8_4 = GrupoCurso::create([
      'curso_id' => $curso_7->id,
      'docente_id' => $docente_11->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_8_4->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear docente: BERTHA OLANDA VELASQUEZ
    $docente_12 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'BERTHA OLANDA VELASQUEZ',
        'email' => 'bolanda@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGEBRA LINEAL NUMERICA
    $grupo_8_4 = GrupoCurso::create([
      'curso_id' => $curso_7->id,
      'docente_id' => $docente_12->id,
      'turno' => 'B',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'viernes',
      'grupo_curso_id' => $grupo_8_4->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear curso: ALGORITMOS Y ESTRUCTURA DE DATOS
    $curso_8 = Curso::create(['nombre' => 'ALGORITMOS Y ESTRUCTURA DE DATOS']);

// Crear docente: PERCY MALDONADO QUISPE
    $docente_13 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'PERCY MALDONADO QUISPE',
        'email' => 'pmaldonado@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
    $grupo_9_3 = GrupoCurso::create([
      'curso_id' => $curso_8->id,
      'docente_id' => $docente_13->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_9_3->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
    $grupo_9_3 = GrupoCurso::create([
      'curso_id' => $curso_8->id,
      'docente_id' => $docente_13->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_9_3->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear docente: ALFREDO PAZ VALDERRAMA
    $docente_14 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ALFREDO PAZ VALDERRAMA',
        'email' => 'apazv@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
    $grupo_9_3 = GrupoCurso::create([
      'curso_id' => $curso_8->id,
      'docente_id' => $docente_14->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_9_3->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear curso: ANALISIS Y DISEÑO DE ALGORITMOS
    $curso_9 = Curso::create(['nombre' => 'ANALISIS Y DISEÑO DE ALGORITMOS']);

// Crear aula: Aula 26.4-207/AULA 203
    $aula_5 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 26.4-207/AULA 203'
    ]);

// Crear grupo para ANALISIS Y DISEÑO DE ALGORITMOS
    $grupo_10_2 = GrupoCurso::create([
      'curso_id' => $curso_9->id,
      'docente_id' => $docente_14->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_10_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear curso: LENGUA EXTRANJERA V
    $curso_10 = Curso::create(['nombre' => 'LENGUA EXTRANJERA V']);

// Crear docente: SONIA BENILDA CALLOAPAZA PARI
    $docente_15 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'SONIA BENILDA CALLOAPAZA PARI',
        'email' => 'scalloapaza@unsa.edu.pe',
      ])->id,
    ]);

// Crear aula: Aula 26.4-106/AULA 101
    $aula_6 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 26.4-106/AULA 101'
    ]);

// Crear grupo para LENGUA EXTRANJERA V
    $grupo_11_1 = GrupoCurso::create([
      'curso_id' => $curso_10->id,
      'docente_id' => $docente_15->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_11_1->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: ARQUITECTURA DE COMPUTADORES
    $curso_11 = Curso::create(['nombre' => 'ARQUITECTURA DE COMPUTADORES']);

// Crear docente: PEDRO ALEX RODRIGUEZ GONZALEZ
    $docente_16 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'PEDRO ALEX RODRIGUEZ GONZALEZ',
        'email' => 'prodriguez@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ARQUITECTURA DE COMPUTADORES
    $grupo_12_2 = GrupoCurso::create([
      'curso_id' => $curso_11->id,
      'docente_id' => $docente_16->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_12_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ARQUITECTURA DE COMPUTADORES
    $grupo_12_2 = GrupoCurso::create([
      'curso_id' => $curso_11->id,
      'docente_id' => $docente_16->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_12_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: DESARROLLO BASADO EN PLATAFORMAS
    $curso_12 = Curso::create(['nombre' => 'DESARROLLO BASADO EN PLATAFORMAS']);

// Crear docente: EDWARD HINOJOSA CARDENAS
    $docente_17 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'EDWARD HINOJOSA CARDENAS',
        'email' => 'ehinojosa@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para DESARROLLO BASADO EN PLATAFORMAS
    $grupo_13_2 = GrupoCurso::create([
      'curso_id' => $curso_12->id,
      'docente_id' => $docente_17->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_13_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para DESARROLLO BASADO EN PLATAFORMAS
    $grupo_13_2 = GrupoCurso::create([
      'curso_id' => $curso_12->id,
      'docente_id' => $docente_17->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_13_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: CIENCIAS DE LA COMPUTACION II
    $curso_13 = Curso::create(['nombre' => 'CIENCIAS DE LA COMPUTACION II']);

// Crear docente: ALVARO HENRY MAMANI ALIAGA
    $docente_18 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ALVARO HENRY MAMANI ALIAGA',
        'email' => 'amamaniali@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para CIENCIAS DE LA COMPUTACION II
    $grupo_14_2 = GrupoCurso::create([
      'curso_id' => $curso_13->id,
      'docente_id' => $docente_18->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_14_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear docente: MARCELA QUISPE CRUZ
    $docente_19 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'MARCELA QUISPE CRUZ',
        'email' => 'mquispecr@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para CIENCIAS DE LA COMPUTACION II
    $grupo_14_2 = GrupoCurso::create([
      'curso_id' => $curso_13->id,
      'docente_id' => $docente_19->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_14_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: TEORIA DE LA COMPUTACION
    $curso_14 = Curso::create(['nombre' => 'TEORIA DE LA COMPUTACION']);

// Crear grupo para TEORIA DE LA COMPUTACION
    $grupo_15_2 = GrupoCurso::create([
      'curso_id' => $curso_14->id,
      'docente_id' => $docente_18->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_15_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear docente: YUBER ELMER VELAZCO PAREDES
    $docente_20 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'YUBER ELMER VELAZCO PAREDES',
        'email' => 'yvelazco@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
    $grupo_15_2 = GrupoCurso::create([
      'curso_id' => $curso_14->id,
      'docente_id' => $docente_20->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '7:00',
      'horaFin' => '8:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_15_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: TRABAJO INTERDISCIPLINAR I
    $curso_15 = Curso::create(['nombre' => 'TRABAJO INTERDISCIPLINAR I']);

// Crear docente: ROXANA FLORES QUISPE
    $docente_21 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ROXANA FLORES QUISPE',
        'email' => 'rfloresqu@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para TRABAJO INTERDISCIPLINAR I
    $grupo_16_2 = GrupoCurso::create([
      'curso_id' => $curso_15->id,
      'docente_id' => $docente_21->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_16_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para TRABAJO INTERDISCIPLINAR I
    $grupo_16_2 = GrupoCurso::create([
      'curso_id' => $curso_15->id,
      'docente_id' => $docente_20->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_16_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: BASE DE DATOS I
    $curso_16 = Curso::create(['nombre' => 'BASE DE DATOS I']);

// Crear grupo para BASE DE DATOS I
    $grupo_17_3 = GrupoCurso::create([
      'curso_id' => $curso_16->id,
      'docente_id' => $docente_17->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_17_3->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para BASE DE DATOS I
    $grupo_17_3 = GrupoCurso::create([
      'curso_id' => $curso_16->id,
      'docente_id' => $docente_17->id,
      'turno' => 'A',
      'tipo' => 'laboratorio',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_17_3->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear grupo para BASE DE DATOS I
    $grupo_17_3 = GrupoCurso::create([
      'curso_id' => $curso_16->id,
      'docente_id' => $docente_17->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_17_3->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: ESTADISTICA Y PROBABILIDADES
    $curso_17 = Curso::create(['nombre' => 'ESTADISTICA Y PROBABILIDADES']);

// Crear docente: ANTONIA QUISPE MAMANI
    $docente_22 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ANTONIA QUISPE MAMANI',
        'email' => 'aquispem@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ESTADISTICA Y PROBABILIDADES
    $grupo_18_2 = GrupoCurso::create([
      'curso_id' => $curso_17->id,
      'docente_id' => $docente_22->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_18_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ESTADISTICA Y PROBABILIDADES
    $grupo_18_2 = GrupoCurso::create([
      'curso_id' => $curso_17->id,
      'docente_id' => $docente_22->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_18_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: SISTEMAS OPERATIVOS
    $curso_18 = Curso::create(['nombre' => 'SISTEMAS OPERATIVOS']);

// Crear grupo para SISTEMAS OPERATIVOS
    $grupo_19_2 = GrupoCurso::create([
      'curso_id' => $curso_18->id,
      'docente_id' => $docente_21->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '16:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_19_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear docente: ROLANDO JESUS CARDENAS TALAVERA
    $docente_23 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ROLANDO JESUS CARDENAS TALAVERA',
        'email' => 'rcardenastal@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para SISTEMAS OPERATIVOS
    $grupo_19_2 = GrupoCurso::create([
      'curso_id' => $curso_18->id,
      'docente_id' => $docente_23->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '16:40',
      'horaFin' => '17:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_19_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear curso: MATEMATICA APLICADA A LA COMPUTACION
    $curso_19 = Curso::create(['nombre' => 'MATEMATICA APLICADA A LA COMPUTACION']);

// Crear docente: ADHA MORALES MOYA
    $docente_24 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ADHA MORALES MOYA',
        'email' => 'amoralesmo@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para MATEMATICA APLICADA A LA COMPUTACION
    $grupo_20_2 = GrupoCurso::create([
      'curso_id' => $curso_19->id,
      'docente_id' => $docente_24->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '18:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_20_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear docente: RICARDO JAVIER HANCCO ANCORI
    $docente_25 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'RICARDO JAVIER HANCCO ANCORI',
        'email' => 'rhanccoan@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para MATEMATICA APLICADA A LA COMPUTACION
    $grupo_20_2 = GrupoCurso::create([
      'curso_id' => $curso_19->id,
      'docente_id' => $docente_25->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '07:00',
      'horaFin' => '07:50',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_20_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear curso: INGENIERIA DE SOFTWARE II
    $curso_20 = Curso::create(['nombre' => 'INGENIERIA DE SOFTWARE II']);

// Crear docente: EDGAR SARMIENTO CALISAYA
    $docente_26 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'EDGAR SARMIENTO CALISAYA',
        'email' => 'esarmientoca@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para INGENIERIA DE SOFTWARE II
    $grupo_21_2 = GrupoCurso::create([
      'curso_id' => $curso_20->id,
      'docente_id' => $docente_26->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '13:10',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_21_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear grupo para INGENIERIA DE SOFTWARE II
    $grupo_21_2 = GrupoCurso::create([
      'curso_id' => $curso_20->id,
      'docente_id' => $docente_26->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '13:10',
      'horaFin' => '14:00',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_21_2->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear curso: TRABAJO INTERDISCIPLINAR II
    $curso_21 = Curso::create(['nombre' => 'TRABAJO INTERDISCIPLINAR II']);

// Crear docente: YESSENIA DEYSI YARI RAMOS
    $docente_27 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'YESSENIA DEYSI YARI RAMOS',
        'email' => 'yyarira@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para TRABAJO INTERDISCIPLINAR II
    $grupo_22_1 = GrupoCurso::create([
      'curso_id' => $curso_21->id,
      'docente_id' => $docente_27->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '11:30',
      'horaFin' => '12:20',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_22_1->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear curso: METODOLOGIA DEL TRABAJO INTELECTUAL
    $curso_22 = Curso::create(['nombre' => 'METODOLOGIA DEL TRABAJO INTELECTUAL']);

// Crear docente: ELVA EMELINA VILLAR GARNICA
    $docente_28 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ELVA EMELINA VILLAR GARNICA',
        'email' => 'evillar@unsa.edu.pe',
      ])->id,
    ]);

// Crear aula: Aula Lab 2/26.4-105
    $aula_7 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula Lab 2/26.4-105'
    ]);

// Crear grupo para METODOLOGIA DEL TRABAJO INTELECTUAL
    $grupo_23_1 = GrupoCurso::create([
      'curso_id' => $curso_22->id,
      'docente_id' => $docente_28->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '07:00',
      'horaFin' => '08:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_23_1->id,
      'aula_id' => $aula_7->id,
    ]);

// Crear curso: RELACIONES HUMANAS
    $curso_23 = Curso::create(['nombre' => 'RELACIONES HUMANAS']);

// Crear grupo para RELACIONES HUMANAS
    $grupo_24_1 = GrupoCurso::create([
      'curso_id' => $curso_23->id,
      'docente_id' => $docente_7->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '07:00',
      'horaFin' => '08:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_24_1->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: TOPICOS DE INGENIERIA DE SOFTWARE
    $curso_24 = Curso::create(['nombre' => 'TOPICOS DE INGENIERIA DE SOFTWARE']);

// Crear grupo para TOPICOS DE INGENIERIA DE SOFTWARE
    $grupo_25_1 = GrupoCurso::create([
      'curso_id' => $curso_24->id,
      'docente_id' => $docente_26->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_25_1->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: COMPUTACION PARALELA Y DISTRIBUIDA
    $curso_25 = Curso::create(['nombre' => 'COMPUTACION PARALELA Y DISTRIBUIDA']);

// Crear grupo para COMPUTACION PARALELA Y DISTRIBUIDA
    $grupo_26_1 = GrupoCurso::create([
      'curso_id' => $curso_25->id,
      'docente_id' => $docente_20->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_26_1->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: INTERACCION HUMANO COMPUTADORA
    $curso_26 = Curso::create(['nombre' => 'INTERACCION HUMANO COMPUTADORA']);

// Crear docente: ANA MARIA CUADROS VALDIVIA
    $docente_29 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ANA MARIA CUADROS VALDIVIA',
        'email' => 'acuadrosv@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para INTERACCION HUMANO COMPUTADORA
    $grupo_27_2 = GrupoCurso::create([
      'curso_id' => $curso_26->id,
      'docente_id' => $docente_29->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '08:50',
      'horaFin' => '10:30',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_27_2->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear grupo para INTERACCION HUMANO COMPUTADORA
    $grupo_27_2 = GrupoCurso::create([
      'curso_id' => $curso_26->id,
      'docente_id' => $docente_29->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_27_2->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: PROYECTO FINAL DE CARRERA I
    $curso_27 = Curso::create(['nombre' => 'PROYECTO FINAL DE CARRERA I']);

// Crear grupo para PROYECTO FINAL DE CARRERA I
    $grupo_28_1 = GrupoCurso::create([
      'curso_id' => $curso_27->id,
      'docente_id' => $docente_21->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '08:50',
      'horaFin' => '10:30',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_28_1->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: FISICA COMPUTACIONAL
    $curso_28 = Curso::create(['nombre' => 'FISICA COMPUTACIONAL']);

// Crear docente: WILSON RICARDO CABANA HANCCO
    $docente_30 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'WILSON RICARDO CABANA HANCCO',
        'email' => 'wcabana@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para FISICA COMPUTACIONAL
    $grupo_29_2 = GrupoCurso::create([
      'curso_id' => $curso_28->id,
      'docente_id' => $docente_30->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'jueves',
      'grupo_curso_id' => $grupo_29_2->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear grupo para FISICA COMPUTACIONAL
    $grupo_29_2 = GrupoCurso::create([
      'curso_id' => $curso_28->id,
      'docente_id' => $docente_30->id,
      'turno' => 'B',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_29_2->id,
      'aula_id' => $aula_6->id,
    ]);

// Crear curso: CLOUD COMPUTING
    $curso_29 = Curso::create(['nombre' => 'CLOUD COMPUTING']);

// Crear aula: Aula 26.4-305/AULA 301
    $aula_8 = Aula::create([
      'tipo' => 'teoria',
      'nombre' => 'Aula 26.4-305/AULA 301'
    ]);

// Crear grupo para CLOUD COMPUTING
    $grupo_30_1 = GrupoCurso::create([
      'curso_id' => $curso_29->id,
      'docente_id' => $docente_18->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '13:10',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_30_1->id,
      'aula_id' => $aula_8->id,
    ]);

// Crear curso: TOPICOS EN CIBERSEGURIDAD
    $curso_30 = Curso::create(['nombre' => 'TOPICOS EN CIBERSEGURIDAD']);

// Crear grupo para TOPICOS EN CIBERSEGURIDAD
    $grupo_31_1 = GrupoCurso::create([
      'curso_id' => $curso_30->id,
      'docente_id' => $docente_23->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '16:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_31_1->id,
      'aula_id' => $aula_8->id,
    ]);

// Crear curso: TRABAJO INTERDISCIPLINAR III
    $curso_31 = Curso::create(['nombre' => 'TRABAJO INTERDISCIPLINAR III']);

// Crear grupo para TRABAJO INTERDISCIPLINAR III
    $grupo_32_1 = GrupoCurso::create([
      'curso_id' => $curso_31->id,
      'docente_id' => $docente_27->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '14:50',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_32_1->id,
      'aula_id' => $aula_8->id,
    ]);

// Crear curso: INTERNET DE LAS COSAS
    $curso_32 = Curso::create(['nombre' => 'INTERNET DE LAS COSAS']);

// Crear grupo para INTERNET DE LAS COSAS
    $grupo_33_1 = GrupoCurso::create([
      'curso_id' => $curso_32->id,
      'docente_id' => $docente_13->id,
      'turno' => 'A',
      'tipo' => 'teoria',
    ]);

// Crear bloque horario
    BloqueHorario::create([
      'horaInicio' => '16:40',
      'horaFin' => '17:30',
      'dia' => 'jueves',
      'grupo_curso_id' => $grupo_33_1->id,
      'aula_id' => $aula_8->id,
    ]);

    $yo = Alumno::create([
      'user_id' => User::factory()->create(['name' => 'Esdras Amado Diaz Vasquez', 'email' => 'test@example.com'])->id
    ]);
    // Matricular al alumno en sus cursos
    $matriculas = [
      $grupo_20_2->id,
      $grupo_21_2->id,
      $grupo_19_2->id,
      $grupo_22_1->id,
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
    }
  }
}
