<?php

namespace App\Infrastructure\Admin\Repository;

use App\Application\Admin\DTOs\NewUserDTO;
use App\Application\Admin\DTOs\UserManagementDTO;
use App\Domain\Admin\Repository\IUserRepository;
use App\Domain\Shared\Exception\InvalidValue;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\User as EloquentUser;

class EloquentUserRepository implements IUserRepository
{
    /**
     * @return UserManagementDTO[]
     */
    public function search(string $query): array
    {
        $searchQuery = "%$query%";

        return EloquentUser::query()
            ->where('name', 'LIKE', $searchQuery)
            ->orWhere('email', 'LIKE', $searchQuery)
            ->get()
            ->map(function (EloquentUser $user) {
                return UserManagementDTO::create(
                    id: Id::fromInt($user->id),
                    name: $user->name,
                    email: $user->email,
                    role: $user->role,
                );
            })
            ->toArray();
    }

    /**
     * @throws InvalidValue
     */
    public function save(NewUserDTO $dto): Id
    {
        $user = new EloquentUser([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'role' => $dto->role,
        ]);

        $user->save();

        if ($user->role === 'student') {
            $user->alumno()->create([]);
        } elseif ($user->role === 'teacher') {
            $user->docente()->create([]);
        }

        return Id::fromInt($user->id);
    }
}
