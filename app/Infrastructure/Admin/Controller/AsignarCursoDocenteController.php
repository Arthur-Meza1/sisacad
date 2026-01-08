<?php

namespace App\Infrastructure\Admin\Controller;

use App\Infrastructure\Shared\Model\BloqueHorario;
use App\Infrastructure\Shared\Model\GrupoCurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsignarCursoDocenteController
{
  public function __invoke(Request $request)
  {
    // ✅ Validación
    $data = $request->validate([
      'turno'       => ['required', 'string'],
      'docente_id'  => ['required', 'integer', 'exists:docentes,id'],
      'curso_id'    => ['required', 'integer', 'exists:cursos,id'],
      'tipo'        => ['required', 'in:teoria,laboratorio'],

      'horaInicio'  => ['required', 'date_format:H:i'],
      'horaFin'     => ['required', 'date_format:H:i', 'after:horaInicio'],
      'dia'         => ['required', 'string'],
      'aula_id'     => ['required', 'integer', 'exists:aulas,id'],
    ]);

    // ✅ Transacción (TODO o NADA)
    DB::transaction(function () use ($data) {

      $grupo = GrupoCurso::create([
        'turno'      => $data['turno'],
        'docente_id' => $data['docente_id'],
        'curso_id'   => $data['curso_id'],
        'tipo'       => $data['tipo'],
      ]);


      BloqueHorario::create([
        'horaInicio'     => $data['horaInicio'],
        'horaFin'        => $data['horaFin'],
        'dia'            => $data['dia'],
        'grupo_curso_id' => $grupo->id,
        'aula_id'        => $data['aula_id'],
      ]);
    });

    // ✅ Respuesta clara
    return response()->json([
      'message' => 'Curso asignado correctamente'
    ], 201);
  }
}
