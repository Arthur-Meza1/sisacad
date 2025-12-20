<?php

namespace App\Infrastructure\Admin\Controller;

use App\Application\Admin\UseCase\ListCourses;
use App\Application\Admin\UseCase\SearchCourses;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CursoController extends Controller
{
  public function __construct(
    private readonly ListCourses   $listarCursos,
    private readonly SearchCourses $searchCourses
  )
  {
  }

  public function index(): View
  {
    return view('admin.cursos.index', [
      'cursos' => $this->listarCursos->execute(),
    ]);
  }

  public function search(Request $request): View
  {
    $validated = $request->validate([
      'query' => 'required|string|max:100',
    ]);

    $results = $this->searchCourses->execute($validated['query']);

    return view('admin.cursos.search_results', compact('results'));
  }
}
