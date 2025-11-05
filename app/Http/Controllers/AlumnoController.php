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
    $alumno = Alumno::with('user')
      ->where('user_id', Auth::id())
      ->firstOrFail();

    return view('student', compact('alumno'));
  }
}
