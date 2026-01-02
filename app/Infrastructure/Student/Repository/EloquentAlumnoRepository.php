<?php

namespace App\Infrastructure\Student\Repository;

use App\Domain\Shared\Exception\UserNotFound;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Domain\Student\Repository\IAlumnoRepository;
use App\Infrastructure\Shared\Model\Asistencia as EloquentAsistencia;
use App\Infrastructure\Shared\Model\Matricula as EloquentMatricula;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Infrastructure\Student\Parser\ParseAlumnoToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EloquentAlumnoRepository implements IAlumnoRepository
{
    public function getByGrupoCursoId(Id $id): array
    {
        return EloquentMatricula::with('alumno.user')
            ->where('grupo_curso_id', $id->getValue())
            ->get()
            ->map(fn (EloquentMatricula $matricula) => Alumno::fromPrimitive(
                id: Id::fromInt($matricula->alumno->id),
                nombre: $matricula->alumno->user->name
            ))->toArray();
    }

    public function findFromUserIdOrFail(Id $id, bool $loadGrupos = true): Alumno
    {
        try {
            $tables = ['user'];
            if ($loadGrupos) {
                $tables[] = 'grupos.curso';
                $tables[] = 'grupos.docente.user';
            }
            $eloquentAlumno =
              EloquentAlumno::with($tables)
                  ->where('user_id', $id->getValue())->firstOrFail();

            return ParseAlumnoToDomain::fromEloquent($eloquentAlumno, $loadGrupos);
        } catch (ModelNotFoundException $e) {
            throw UserNotFound::execute();
        }
    }

    public function getAsistenciasById(Id $id): Collection
    {
        return EloquentAsistencia::with('sesion.grupoCurso.curso')
            ->where('alumno_id', $id->getValue())
            ->get()
            ->groupBy(fn (EloquentAsistencia $asistencia) => $asistencia->sesion->grupoCurso->curso->id)
            ->map(function ($asistencias) {
                $curso = $asistencias->first()->sesion->grupoCurso->curso;

                return [
                    'curso_nombre' => $curso->nombre,
                    'presentes' => $asistencias->where('presente', true)->count(),
                    'ausentes' => $asistencias->where('presente', false)->count(),
                ];
            });
    }
}
