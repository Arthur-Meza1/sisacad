<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Infrastructure\Shared\Model\Curso;
use App\Infrastructure\Shared\Model\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'users_count' => User::count(),
            'courses_count' => Curso::count(),
        ]);
    }
}
