<?php

namespace App\Http\Controllers;

use App\Models\GrupoCurso;
use App\Services\AlumnoService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
  use AuthorizesRequests;

  private $service;

  public function __construct(AlumnoService $service) {
    $this->service = $service;
  }

  public function index()
  {
    $grupos = $this->service->getGroupDataFromId(Auth::id());

    return view('student', compact('grupos'));
  }

  public function getCursos() {
    return response()->json($this->service->getCursosFromId(Auth::id()));
  }

  public function getNotasCurso(int $curso) {
    return response()->json($this->service->getNotasCursoFromId(Auth::id(), $curso));
  }

  public function getHorario() {
    return response()->json($this->service->getHorarioFromId(Auth::id()));
  }

  public function getCuposMatricula() {
    return response()->json($this->service->getCuposDisponibles(Auth::id()));
  }

  public function matricular(Request $request) {
    $validated = $request->validate([
      'id' => 'required|exists:grupo_cursos,id',
    ]);

    $this->service->matricular(Auth::id(), $validated['id']);

    return response()->json(['success' => true]);
  }

  public function getLaboratorios() {
    return response()->json($this->service->getLaboratorios(Auth::id()));
  }
}
