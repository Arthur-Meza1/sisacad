<?php

namespace App\Infrastructure\Admin\Controller;

use App\Http\Controllers\Controller;
use App\Application\Admin\UseCase\FindUsersQuery;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
  // Inyectamos el Caso de Uso
  public function __construct(private readonly FindUsersQuery $findUsersQuery) {}

  public function index(): View
  {
    return view('admin.users.index');
  }

  public function search(Request $request):View
  {
    $validated = $request->validate([
      'query' => 'required|string|max:100',
    ]);

    $results = $this->findUsersQuery->execute($validated['query']);

    // El helper 'view()' devuelve un objeto View
    return view('admin.users.search_results', compact('results'));
  }
}
