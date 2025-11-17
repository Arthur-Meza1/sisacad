<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Services\DocenteService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
  use AuthorizesRequests;

  private $service;

  public function __construct(DocenteService $service) {
    $this->service = $service;
  }

  public function index()
  {
    $grupos = $this->service->getGroupDataFromId(Auth::id());

    return view('teacher', compact('grupos'));
  }

  public function getHorario() {
    return response()->json($this->service->getHorarioFromId(Auth::id()));
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
