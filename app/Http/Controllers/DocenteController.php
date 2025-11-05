<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DocenteController extends Controller
{
  use AuthorizesRequests;

  public function index()
  {
    $docente = Docente::with('user')
      ->where('user_id', Auth::id())
      ->firstOrFail();

    return view('teacher', compact('docente'));
  }
}
