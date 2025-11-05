<?php

namespace App\Http\Controllers;

use App\Models\GrupoCurso;
use App\Models\Sesion;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
  // Página principal: lista de grupos del docente
  public function index()
  {
    $docente = Auth::user()->docente;

    // Cargamos todos los grupos con el curso asociado
    $grupos = $docente->grupos()->with('curso')->get();

    return view('teacher.asistencia', compact('grupos'));
  }

  // Formulario para tomar asistencia de un grupo específico
  public function mostrarFormulario(GrupoCurso $grupo)
  {
    $alumnos = $grupo->alumnos()->with('user')->get();

    return view('teacher.asistencia_form', compact('grupo', 'alumnos'));
  }

  // Guardar la asistencia
  public function guardarAsistencia(Request $request, GrupoCurso $grupo)
  {
    $validated = $request->validate([
      'asistencia' => 'required|array',
    ]);

    // Crear o reutilizar la sesión del día actual
    $sesion = Sesion::firstOrCreate([
      'grupo_curso_id' => $grupo->id,
      'fecha' => now()->toDateString(),
      'horaInicio' => now()->toTimeString(),
      'horaFin' => now()->addHour()->toTimeString(),
    ]);

    foreach ($validated['asistencia'] as $alumno_id => $presente) {
      Asistencia::updateOrCreate(
        ['alumno_id' => $alumno_id,
          'sesion_id' => $sesion->id],
        ['presente' => $presente]
      );
    }

    return redirect()->route('asistencia.index')->with('success', 'Asistencia registrada correctamente.');
  }
}
