<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Exception\RegistroNotFound;
use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;
use App\Domain\Student\Exception\AlumnoNotFound;
use App\Infrastructure\Shared\Model\Registro as EloquentRegistro;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Infrastructure\Student\Parser\ParseRegistroToDomain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRegistroRepository implements IRegistroRepository
{
    public function getOrCreateByAlumnoInGrupo(Id $alumnoId, Id $grupoId): Registro
    {
        try {
            $eloquentAlumno = EloquentAlumno::findOrFail($alumnoId->getValue());

            $eloquentRegistro =
              $eloquentAlumno
                  ->registros()
                  ->where('grupo_curso_id', $grupoId->getValue())
                  ->first();

            if (! $eloquentRegistro) {
                $eloquentRegistro = $eloquentAlumno->registros()->create([
                    'grupo_curso_id' => $grupoId->getValue(),
                ]);
            }

            return ParseRegistroToDomain::fromEloquent($eloquentRegistro);
        } catch (ModelNotFoundException) {
            throw AlumnoNotFound::execute($alumnoId);
        }
    }

    public function getById(Id $id): Registro
    {
        try {
            $eloquentRegistro = EloquentRegistro::findOrFail($id->getValue());

            return ParseRegistroToDomain::fromEloquent($eloquentRegistro);
        } catch (ModelNotFoundException) {
            throw RegistroNotFound::execute($id);
        }
    }

    public function save(Registro $registro): void
    {
        $data = [
            'parcial1' => $registro->parcial()->unidad1(),
            'parcial2' => $registro->parcial()->unidad2(),
            'parcial3' => $registro->parcial()->unidad3(),
            'sustitutorio' => $registro->parcial()->sustitutorio(),
            'continua1' => $registro->continua()->unidad1(),
            'continua2' => $registro->continua()->unidad2(),
            'continua3' => $registro->continua()->unidad3(),
        ];

        $updated = EloquentRegistro::whereKey($registro->id()->getValue())
            ->update($data);
    }
}
