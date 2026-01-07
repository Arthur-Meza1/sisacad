<?php

namespace App\Infrastructure\Student\Parser;

use App\Domain\Shared\Entity\Curso;
use App\Domain\Shared\Entity\GrupoCurso;
use App\Domain\Shared\Entity\Tema;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Id;
use App\Domain\Student\Entity\Alumno;
use App\Infrastructure\Student\Model\Alumno as EloquentAlumno;

class ParseAlumnoToDomain {
  public static function fromEloquent(EloquentAlumno $eloquentAlumno, bool $loadGrupos): Alumno {
    $alumno = Alumno::fromPrimitive(
      id: Id::fromInt($eloquentAlumno->id),
      nombre: $eloquentAlumno->user->name
    );

    if($loadGrupos) {
      $eloquentAlumno->grupos->each(function ($grupo) use (&$alumno) {
        $curso = GrupoCurso::fromPrimitive(
          id:  Id::fromInt($grupo->id),
          curso: Curso::create(Id::fromInt($grupo->curso->id), $grupo->curso->nombre),
          grupoTurno: GrupoTurno::fromString($grupo->turno),
          cursoTipo: CursoTipo::fromString($grupo->tipo),
          docenteNombre: $grupo->docente->user->name
        );

        // Agrupar capítulos por unidad y luego iterar por unidad->capítulo->temas
        $unidades = [];

        $grupo->curso->capitulos->sortBy('orden')->each(function ($capitulo) use (&$curso, &$unidades) {
          $unidadId = $capitulo->unidad_id ?? 1;

          $unidadNombre = match($unidadId) {
            1 => 'PRIMERA UNIDAD',
            2 => 'SEGUNDA UNIDAD',
            3 => 'TERCERA UNIDAD',
            4 => 'CUARTA UNIDAD',
            default => 'UNIDAD ' . $unidadId
          };

          $temasCollection = collect();
          $capitulo->temas->sortBy('orden')->each(function ($tema) use (&$curso, $temasCollection) {
            $temaEntity = Tema::fromPrimitives(
              $tema->titulo,
              $tema->orden,
              $tema->id
            );

            // Agregar a la lista plana (todos los temas del curso)
            $curso->addTema($temaEntity);
            $temasCollection->push($temaEntity);
          });

          // Preparar estructura de capítulo para la unidad
          $capArr = [
            'nombre' => $capitulo->nombre,
            'temas' => $temasCollection
          ];

          if (!isset($unidades[$unidadId])) {
            $unidades[$unidadId] = [
              'nombre' => $unidadNombre,
              'capitulos' => []
            ];
          }

          $unidades[$unidadId]['capitulos'][] = $capArr;
        });

        // Registrar unidades ordenadas por unidad id
        ksort($unidades);
        foreach ($unidades as $u) {
          // convertir capitulos a Collection de arrays con 'nombre' y 'temas' (Collection)
          $capCollection = collect($u['capitulos']);
          $curso->addUnidad($u['nombre'], $capCollection);
        }

        $alumno->addGrupo($curso);
      });
    }

    return $alumno;
  }

}
