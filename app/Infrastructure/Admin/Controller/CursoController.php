<?php

namespace App\Infrastructure\Admin\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CursoController extends Controller
{

  public function index(): View
  {
    return view('admin.cursos.index');
  }
}
