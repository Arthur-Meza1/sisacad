<?php

namespace App\Infrastructure\Admin\Controller;

use App\Application\Admin\DTOs\NewUserDTO;
use App\Application\Admin\UseCase\CreateNewUserCommand;
use App\Application\Admin\UseCase\FindUsersQuery;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Inyectamos el Caso de Uso
    public function __construct(
        private readonly FindUsersQuery $findUsersQuery,
        private readonly CreateNewUserCommand $createNewUserCommand
    ) {}

    public function index(): View
    {
        return view('admin.users.index');
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'query' => 'required|string|max:100',
        ]);

        $results = $this->findUsersQuery->execute($validated['query']);

        // El helper 'view()' devuelve un objeto View
        return view('admin.users.search_results', compact('results'));
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,teacher,student',
        ]);

        $dto = new NewUserDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
            role: $validated['role']
        );

        $this->createNewUserCommand->handle($dto);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }
}
