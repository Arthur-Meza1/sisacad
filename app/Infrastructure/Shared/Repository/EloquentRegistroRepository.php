<?php

namespace App\Infrastructure\Shared\Repository;

use App\Domain\Shared\Exception\RegistroNotFound;
use App\Domain\Shared\Repository\IRegistroRepository;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Shared\ValueObject\Registro;
use App\Domain\Student\Exception\AlumnoNotFound;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;
use App\Infrastructure\Student\Parser\ParseRegistroToDomain;
use App\Infrastructure\Shared\Model\Registro as EloquentRegistro;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRegistroRepository implements IRegistroRepository {
  public function getOrCreateByAlumnoInGrupo(Id $alumnoId, Id $grupoId): Registro {
    try {
      $eloquentAlumno = EloquentAlumno::findOrFail($alumnoId->getValue());

      $eloquentRegistro =
        $eloquentAlumno
          ->registros()
          ->where('grupo_curso_id', $grupoId->getValue())
          ->first();

      if(!$eloquentRegistro) {
        $eloquentRegistro = $eloquentAlumno->registros()->create([
          'grupo_curso_id' => $grupoId->getValue(),
        ]);
      }

      return ParseRegistroToDomain::fromEloquent($eloquentRegistro);
    } catch(ModelNotFoundException) {
      throw AlumnoNotFound::execute($alumnoId);
    }
  }

  public function save(Registro $registro): void
  {
    $data = [];

    $parcial = $registro->parcial();
    if ($parcial->unidad1() !== null) {
      $data['parcial1'] = $parcial->unidad1();
    }
    if ($parcial->unidad2() !== null) {
      $data['parcial2'] = $parcial->unidad2();
    }
    if ($parcial->unidad3() !== null) {
      $data['parcial3'] = $parcial->unidad3();
    }
    if ($parcial->sustitutorio() !== null) {
      $data['sustitutorio'] = $parcial->sustitutorio();
    }

    $continua = $registro->continua();
    if ($continua->unidad1() !== null) {
      $data['continua1'] = $continua->unidad1();
    }
    if ($continua->unidad2() !== null) {
      $data['continua2'] = $continua->unidad2();
    }
    if ($continua->unidad3() !== null) {
      $data['continua3'] = $continua->unidad3();
    }

    if (empty($data)) {
      return; // nada que persistir
    }

    $updated = EloquentRegistro::whereKey($registro->id()->getValue())
      ->update($data);

    if ($updated === 0) {
      throw RegistroNotFound::execute($registro->id());
    }
  }
}
