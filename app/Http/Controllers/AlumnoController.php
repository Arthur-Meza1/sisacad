<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class AlumnoController extends Controller
{
  use AuthorizesRequests;

  public function index()
  {
    return view('student');
  }

  public function getCursos() {
    $alumno = Auth::user()->alumno;
    $cursos =
      $alumno->grupos()
             ->where('tipo', 'teoria')
             ->with('curso')
             ->get()
             ->map(fn ($grupo) => ['id' => $grupo->id, 'nombre' => $grupo->curso->nombre]);
    return response()->json($cursos);
  }

  public function getNotasCurso(int $curso) {
    $alumno = Auth::user()->alumno;
    $notas = $alumno->registros()
                    ->where('grupo_curso_id', $curso)
                    ->first();

    $parcial1 = $notas['parcial1'];
    $parcial2 = $notas['parcial2'];
    if(($sust = $notas['sustitutorio']) != null) {
      if($parcial1 < $parcial2) {
        $parcial1 = $sust;
      } else {
        $parcial2 = $sust;
      }
    }

    return response()->json([
      'Parcial' => [$parcial1, $parcial2, $notas['parcial3']],
      'Continua' => [$notas['continua1'], $notas['continua2'], $notas['continua3']],
    ]);
  }
}
