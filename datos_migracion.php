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

// Crear docente: ALFREDO PAZ VALDERRAMA
$docente_13 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ALFREDO PAZ VALDERRAMA',
        'email' => 'apazv@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
$grupo_9_5 = GrupoCurso::create([
        'curso_id' => $curso_8->id,
        'docente_id' => $docente_13->id,
        'turno' => 'A',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '8:50',
      'horaFin' => '10:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_9_5->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear docente: ALVARO HENRY MAMANI ALIAGA
$docente_14 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ALVARO HENRY MAMANI ALIAGA',
        'email' => 'amamaniali@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
$grupo_9_5 = GrupoCurso::create([
        'curso_id' => $curso_8->id,
        'docente_id' => $docente_14->id,
        'turno' => 'A',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_9_5->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
$grupo_9_5 = GrupoCurso::create([
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
      'grupo_curso_id' => $grupo_9_5->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
$grupo_9_5 = GrupoCurso::create([
        'curso_id' => $curso_8->id,
        'docente_id' => $docente_13->id,
        'turno' => 'B',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_9_5->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear grupo para ALGORITMOS Y ESTRUCTURA DE DATOS
$grupo_9_5 = GrupoCurso::create([
        'curso_id' => $curso_8->id,
        'docente_id' => $docente_13->id,
        'turno' => 'B',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '15:50',
      'horaFin' => '17:30',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_9_5->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: ESTADISTICA Y PROBABILIDADES
$curso_9 = Curso::create(['nombre' => 'ESTADISTICA Y PROBABILIDADES']);

// Crear docente: ANTONIA QUISPE MAMANI
$docente_15 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'ANTONIA QUISPE MAMANI',
        'email' => 'aquispem@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para ESTADISTICA Y PROBABILIDADES
$grupo_10_2 = GrupoCurso::create([
        'curso_id' => $curso_9->id,
        'docente_id' => $docente_15->id,
        'turno' => 'A',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_10_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para ESTADISTICA Y PROBABILIDADES
$grupo_10_2 = GrupoCurso::create([
        'curso_id' => $curso_9->id,
        'docente_id' => $docente_15->id,
        'turno' => 'B',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_10_2->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear curso: BASE DE DATOS I
$curso_10 = Curso::create(['nombre' => 'BASE DE DATOS I']);

// Crear docente: EDWARD HINOJOSA CARDENAS
$docente_16 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'EDWARD HINOJOSA CARDENAS',
        'email' => 'ehinojosa@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'A',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'A',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '12:20',
      'horaFin' => '14:00',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'B',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'C',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear aula: Laboratorio 4
$aula_5 = Aula::create([
      'tipo' => 'laboratorio',
      'nombre' => 'Laboratorio 4'
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'C',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'jueves',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_5->id,
    ]);

// Crear grupo para BASE DE DATOS I
$grupo_11_6 = GrupoCurso::create([
        'curso_id' => $curso_10->id,
        'docente_id' => $docente_16->id,
        'turno' => 'B',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_11_6->id,
      'aula_id' => $aula_3->id,
    ]);

// Crear curso: TEORIA DE LA COMPUTACION
$curso_11 = Curso::create(['nombre' => 'TEORIA DE LA COMPUTACION']);

// Crear docente: YUBER ELMER VELAZCO PAREDES
$docente_17 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'YUBER ELMER VELAZCO PAREDES',
        'email' => 'yvelazco@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
$grupo_12_5 = GrupoCurso::create([
        'curso_id' => $curso_11->id,
        'docente_id' => $docente_17->id,
        'turno' => 'A',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '7:50',
      'horaFin' => '9:40',
      'dia' => 'martes',
      'grupo_curso_id' => $grupo_12_5->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
$grupo_12_5 = GrupoCurso::create([
        'curso_id' => $curso_11->id,
        'docente_id' => $docente_17->id,
        'turno' => 'A',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '10:40',
      'horaFin' => '12:20',
      'dia' => 'viernes',
      'grupo_curso_id' => $grupo_12_5->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear docente: MARCELA QUISPE CRUZ
$docente_18 = Docente::create(['user_id' =>
      User::factory()->create([
        'role' => 'teacher',
        'name' => 'MARCELA QUISPE CRUZ',
        'email' => 'mquispecr@unsa.edu.pe',
      ])->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
$grupo_12_5 = GrupoCurso::create([
        'curso_id' => $curso_11->id,
        'docente_id' => $docente_18->id,
        'turno' => 'B',
        'tipo' => 'teoria',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'lunes',
      'grupo_curso_id' => $grupo_12_5->id,
      'aula_id' => $aula_4->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
$grupo_12_5 = GrupoCurso::create([
        'curso_id' => $curso_11->id,
        'docente_id' => $docente_18->id,
        'turno' => 'B',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '14:00',
      'horaFin' => '15:40',
      'dia' => 'viernes',
      'grupo_curso_id' => $grupo_12_5->id,
      'aula_id' => $aula_2->id,
    ]);

// Crear grupo para TEORIA DE LA COMPUTACION
$grupo_12_5 = GrupoCurso::create([
        'curso_id' => $curso_11->id,
        'docente_id' => $docente_17->id,
        'turno' => 'C',
        'tipo' => 'laboratorio',
      ]);

// Crear bloque horario
BloqueHorario::create([
      'horaInicio' => '17:40',
      'horaFin' => '19:20',
      'dia' => 'miercoles',
      'grupo_curso_id' => $grupo_12_5->id,
      'aula_id' => $aula_2->id,
    ]);
