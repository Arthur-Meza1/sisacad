<?php

namespace App\Infrastructure\Shared\Parser;

use App\Domain\Shared\Entity\Curso;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;

class ParseGrupoCursoToDomain
{
    public static function fromEloquent(EloquentGrupoCurso $grupo): GrupoCurso
    {
        return GrupoCurso::fromPrimitive(
            id: Id::fromInt($grupo->id),
            curso: Curso::create(
                id: Id::fromInt($grupo->curso->id),
                nombre: $grupo->curso->nombre,
            ),
            grupoTurno: GrupoTurno::fromString($grupo->turno),
            cursoTipo: CursoTipo::fromString($grupo->tipo),
            docenteNombre: $grupo->docente->user->name,
        );
    }
}
