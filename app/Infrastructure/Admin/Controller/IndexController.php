<?php

namespace App\Infrastructure\Admin\Controller;

use App\Http\Controllers\Controller;
use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Shared\Model\User;
use Illuminate\View\View;

class IndexController extends Controller
{
  public function __invoke(): View
  {
    return view('admin.index', [
      'users_count' => User::count(),
      'courses_count' => Curso::count(),
    ]);
  }
}
