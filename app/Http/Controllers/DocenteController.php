<?php

namespace App\Http\Controllers;

use App\Models\Sesion;
use App\Services\AulaService;
use App\Services\DocenteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
  use AuthorizesRequests;

  private $docenteService;
  private $aulaService;

  public function __construct(DocenteService $docenteService, AulaService $aulaService) {
    $this->docenteService = $docenteService;
    $this->aulaService = $aulaService;
  }

  public function index()
  {
    $grupos = $this->docenteService->getGroupDataFromId(Auth::id());

    return view('teacher', compact('grupos'));
  }

  public function getHorario() {
    return response()->json($this->docenteService->getHorarioFromId(Auth::id()));
  }

  public function getAulasDisponibles(Request $request) {
    $validated = $request->validate([
      'fecha' => 'required|date',
      'hora_inicio' => 'required|date_format:H:i',
      'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
    ]);

    return response()->json($this->aulaService->getAvailableList($validated['fecha'], $validated['hora_inicio'], $validated['hora_fin']));
  }

  public function crearSesion(Request $request) {
    $validated = $request->validate([
      'grupo_id' => 'required|exists:grupo_cursos,id',
      'fecha' => 'required|date',
      'hora_inicio' => 'required|date_format:H:i',
      'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
      'aula_id' => 'required|exists:aulas,id',
      'from_bloque' => 'required'
    ]);

    $sesion = Sesion::create([
      'grupo_curso_id' => $validated['grupo_id'],
      'aula_id' => $validated['aula_id'],
      'fecha' => $validated['fecha'],
      'horaInicio' => $validated['hora_inicio'],
      'horaFin' => $validated['hora_fin'],
      'from_bloque' => $validated['from_bloque']
    ]);

    return response()->json($sesion);
  }

  public function registrarNotas(Request $request)
  {
    $docente = auth()->user()->docente;
    $grupoSeleccionado = null;

    if ($request->filled('grupo_id')) {
      $grupoSeleccionado = $docente->grupos()->with(['curso', 'matriculas.alumno.user', 'matriculas.alumno.registros'])->find($request->grupo_id);
    }

    return view('teacher.registrar_notas', compact('docente', 'grupoSeleccionado'));
  }

  public function guardarNotas(Request $request, $grupoId)
  {
    foreach ($request->input('registros', []) as $matriculaId => $notas) {
      $matricula = \App\Models\Matricula::find($matriculaId);

      $registro = \App\Models\Registro::firstOrNew([
        'alumno_id' => $matricula->alumno_id,
        'grupo_curso_id' => $grupoId,
      ]);

      $registro->fill($notas);
      $registro->save();
    }

    return redirect()->back()->with('success', 'Notas actualizadas correctamente.');
  }

}
