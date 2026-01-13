<?php

namespace App\Infrastructure\Admin\Controller;

use App\Application\Admin\DTOs\NewUserDTO;
use App\Application\Admin\UseCase\CreateNewUserCommand;
use App\Application\Admin\UseCase\ListUsers;
use App\Domain\Shared\ValueObject\Id;
use App\Http\Controllers\Controller;
use App\Application\Admin\UseCase\FindUsersQuery;
use App\Infrastructure\Shared\Model\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Application\Student\UseCase as Student;
use App\Application\Teacher\UseCase as Teacher;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  // Inyectamos el Caso de Uso
  public function __construct(
    private readonly ListUsers            $listUsers,
    private readonly FindUsersQuery       $findUsersQuery,
    private readonly CreateNewUserCommand $createNewUserCommand,
    private readonly Student\GetBasicGruposData $studentGetBasicGruposData,
    private readonly Student\GetHorario $studentGetHorario,
    private readonly Teacher\GetBasicGruposData $teacherGetBasicGruposData,
    private readonly Teacher\GetHorario $teacherGetHorario,
  )
  {
  }

  public function index(): View
  {
    $users = $this->listUsers->execute();
    return view('admin.users.index', compact('users'));
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

  public function edit_student(int $userId): View {
    $id = Id::fromInt($userId);
    $student = User::findOrFail($userId);
    $grupos = $this->studentGetBasicGruposData->execute($id);
    $horario = $this->studentGetHorario->execute($id);

    return view('admin.users.show_student', compact('grupos', 'horario', 'student'));
  }

  public function show_teacher(int $userId): View {
    $id = Id::fromInt($userId);
    $grupos = $this->teacherGetBasicGruposData->execute($id);
    $horario = $this->teacherGetHorario->execute($id);

    return view('admin.users.show_teacher', compact('grupos', 'horario'));
  }

  public function edit_teacher(int $userId) {
    $id = Id::fromInt($userId);
    $grupos = $this->teacherGetBasicGruposData->execute($id);
    $horario = $this->teacherGetHorario->execute($id);

    $gruposDisponibles = DB::table('cursos')
      ->crossJoin(DB::raw("(
      SELECT 'teoria' AS tipo
      UNION ALL
      SELECT 'laboratorio'
  ) tipos"))
      ->leftJoin('grupo_cursos', function ($join) {
        $join->on('grupo_cursos.curso_id', '=', 'cursos.id')
          ->on('grupo_cursos.tipo', '=', 'tipos.tipo');
      })
      ->whereNull('grupo_cursos.id')
      ->select(
        'cursos.id as id',
        'cursos.nombre',
        'tipos.tipo'
      )
      ->orderBy('cursos.nombre')
      ->get();

    return view('admin.users.edit_teacher', compact('grupos', 'horario', 'gruposDisponibles') );
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
