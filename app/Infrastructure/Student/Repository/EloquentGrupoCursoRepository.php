<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Repository\IGrupoCursoRepository;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;
use App\Infrastructure\Shared\Model\Matricula as EloquentMatricula;
use App\Infrastructure\Shared\Parser\ParseGrupoCursoToDomain;

class EloquentGrupoCursoRepository implements IGrupoCursoRepository
{
    public function getAvailableLabsFromCurso(GrupoCurso $curso, array $except): array
    {
        return EloquentGrupoCurso::with('curso', 'docente.user')
            ->where('curso_id', $curso->curso()->id()->getValue())
            ->where('tipo', 'laboratorio')
            ->whereIn('turno', $curso->grupoTurno()->getAllowed())
            ->whereNotIn('id', $except)
            ->get()
            ->map(fn (EloquentGrupoCurso $curso) => ParseGrupoCursoToDomain::fromEloquent($curso))
            ->toArray();
    }

    public function matricularEnGrupo(Id $alumnoId, Id $grupoId): void
    {
        EloquentMatricula::create([
            'alumno_id' => $alumnoId->getValue(),
            'grupo_curso_id' => $grupoId->getValue(),
        ]);
    }

    public function desmatricularEnGrupo(Id $alumnoId, Id $grupoId): void
    {
        EloquentMatricula::where('alumno_id', $alumnoId->getValue())
            ->where('grupo_curso_id', $grupoId->getValue())
            ->delete();
    }
}
