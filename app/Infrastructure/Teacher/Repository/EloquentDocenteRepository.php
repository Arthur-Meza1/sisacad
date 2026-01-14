<?php

namespace App\Infrastructure\Teacher\Repository;

use App\Domain\Shared\Exception\UserNotFound;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Teacher\Entity\Docente;
use App\Domain\Teacher\Repository\IDocenteRepository;
use App\Infrastructure\Teacher\Model\Docente as EloquentDocente;
use App\Infrastructure\Teacher\Parser\ParseDocenteToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentDocenteRepository implements IDocenteRepository
{
    public function findFromIdOrFail(Id $id): Docente
    {
        try {
            $docente = EloquentDocente::with('grupos')
                ->where('user_id', $id->getValue())->firstOrFail();

            return ParseDocenteToDomain::fromEloquent($docente);
        } catch (ModelNotFoundException) {
            throw UserNotFound::execute();
        }
    }
}
