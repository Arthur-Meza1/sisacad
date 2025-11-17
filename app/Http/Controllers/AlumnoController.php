<?php

namespace App\Http\Controllers;

use App\Services\AlumnoService;
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
    return view('student');
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
}
