<?php

namespace App\Infrastructure\Admin\Controller;

use App\Application\Admin\UseCase\ListCourses;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CursoController extends Controller
{
  public function __construct(
    private readonly ListCourses $listarCursos
  )
  {
  }

  public function index(): View
  {
    return view('admin.cursos.index', [
      'cursos' => $this->listarCursos->execute(),
    ]);
  }
}
