<?php

namespace App\Infrastructure\Shared\Repository;

use App\Application\Shared\DTOs\BloqueHorarioDTO;
use App\Application\Shared\DTOs\HorarioDTO;
use App\Application\Shared\DTOs\OtherHorarioDTO;
use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Repository\IHorarioRepository;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\BloqueHorario;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;

class EloquentHorarioRepository implements IHorarioRepository {
  public function getOwnHorario(array $grupoIds): HorarioDTO {
    $grupos = EloquentGrupoCurso::with('registros')
      ->whereIn('id', $grupoIds)->get();

    $horario = $grupos->flatMap(function ($grupo) {
      return $grupo->bloqueHorario->map(fn($bloque) => new BloqueHorarioDTO(
        fechaOrDia: Dia::fromString($bloque->dia),
        horaInicio: Hora::fromString($bloque->horaInicio),
        horaFin: Hora::fromString($bloque->horaFin),
        grupoId: Id::fromInt($grupo->id),
        grupoNombre: $grupo->curso->nombre,
        tipo: CursoTipo::fromString($grupo->tipo),
        turno: GrupoTurno::fromString($grupo->turno),
        aulaId: Id::fromInt($bloque->aula->id),
        aulaNombre: $bloque->aula->nombre));
      });

    $sesiones =
      EloquentSesion::with('grupoCurso.curso', 'aula')
        ->whereIn('grupo_curso_id', $grupoIds)
        ->get()
        ->map(fn ($sesion) => new BloqueHorarioDTO(
          fechaOrDia: Fecha::fromString($sesion->fecha),
          horaInicio: Hora::fromString($sesion->horaInicio),
          horaFin: Hora::fromString($sesion->horaFin),
          grupoId: Id::fromInt($sesion->grupoCurso->id),
          grupoNombre: $sesion->grupoCurso->curso->nombre,
          tipo: CursoTipo::fromString($sesion->grupoCurso->tipo),
          turno: GrupoTurno::fromString($sesion->grupoCurso->turno),
          aulaId: Id::fromInt($sesion->aula->id),
          aulaNombre: $sesion->aula->nombre,
        ));

    return new HorarioDTO(
      horario: $horario->all(),
      sesiones: $sesiones->all(),
      otros: []);
  }

  public function getOwnHorarioAndOthers(array $grupoIds): HorarioDTO {
    $res = $this->getOwnHorario($grupoIds);

    $other =
      BloqueHorario::with('aula')
        ->whereNotIn('grupo_curso_id', $grupoIds)
        ->get()
        ->map(fn ($bloque) => new OtherHorarioDTO(
          fechaOrDia:  Dia::fromString($bloque->dia),
          horaInicio: Hora::fromString($bloque->horaInicio),
          horaFin: Hora::fromString($bloque->horaFin),
          aula: $bloque->aula->nombre,
          fromBloque: true,
        ))->merge(
          EloquentSesion::with('aula')
            ->whereNotIn('grupo_curso_id', $grupoIds)
            ->get()
            ->map(fn ($sesion) => new OtherHorarioDTO(
              fechaOrDia:  Fecha::fromString($sesion->fecha),
              horaInicio: Hora::fromString($sesion->horaInicio),
              horaFin: Hora::fromString($sesion->horaFin),
              aula: $sesion->aula->nombre,
              fromBloque: false,
            ))
        )
        ->unique(fn (OtherHorarioDTO $x) => $x->uniqueKey());
    $res->otros = $other->all();

    return $res;
  }
}
