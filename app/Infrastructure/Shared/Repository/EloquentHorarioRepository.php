<?php

namespace App\Infrastructure\Shared\Repository;

use App\Application\Shared\DTOs\BloqueHorarioDTO;
use App\Application\Shared\DTOs\HorarioDTO;
use App\Application\Shared\DTOs\OccuppiedSlotDTO;
use App\Application\Shared\DTOs\OtherHorarioDTO;
use App\Domain\Shared\Repository\IHorarioRepository;
use App\Domain\Shared\ValueObject\CursoTipo;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\GrupoTurno;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use App\Infrastructure\Shared\Model\Aula as EloquentAula;
use App\Infrastructure\Shared\Model\BloqueHorario as EloquentBloqueHorario;
use App\Infrastructure\Shared\Model\GrupoCurso as EloquentGrupoCurso;
use App\Infrastructure\Shared\Model\Sesion as EloquentSesion;
use Illuminate\Support\Collection;

class EloquentHorarioRepository implements IHorarioRepository
{
    public function getFromGrupoIds(array $grupoIds, bool $withOthers): HorarioDTO
    {
        $grupos = EloquentGrupoCurso::with('registros')
            ->whereIn('id', $grupoIds)->get();

        $horario = $grupos->flatMap(function ($grupo) {
            return $grupo->bloqueHorario->map(fn ($bloque) => new BloqueHorarioDTO(
                id: Id::fromInt($bloque->id),
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
                  id: Id::fromInt($sesion->id),
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

        if ($withOthers) {
            $occupied = self::GetIntervalsWithNonEmptySpace(
                self::GetOthersFromGrupoIds($grupoIds),
                EloquentAula::count()
            );
        } else {
            $occupied = [];
        }

        return new HorarioDTO(
            horario: $horario->all(),
            sesiones: $sesiones->all(),
            occupied: $occupied);
    }

    private static function GetIntervalsWithNonEmptySpace(Collection $others, int $totalAulas): array
    {
        $events = [];
        foreach ($others as $o) {
            $events[] = ['fechaOrDia' => $o->fechaOrDia, 't' => $o->horaInicio, 'd' => +1];
            $events[] = ['fechaOrDia' => $o->fechaOrDia, 't' => $o->horaFin, 'd' => -1];
        }

        usort($events, function ($a, $b) {
            $fechaA = $a['fechaOrDia'];
            $fechaB = $b['fechaOrDia'];
            [$carbonA, $carbonB] = self::NormalizeDates($fechaA, $fechaB);

            $dateComparison = $carbonA <=> $carbonB;
            if ($dateComparison !== 0) {
                return $dateComparison;
            }

            return $b['t']->toMinutes() <=> $a['t']->toMinutes();
        });

        $current = 0;
        $lastTime = null;
        $lastFecha = null;
        $intervals = [];

        foreach ($events as $ev) {
            $t = $ev['t'];
            $currentFecha = $ev['fechaOrDia'];

            if ($lastTime !== null && $lastFecha !== null) {
                if (self::AreSameDate($lastFecha, $currentFecha)) {
                    if ($current >= $totalAulas) {
                        $intervals[] = new OccuppiedSlotDTO(
                            fechaOrDia: $lastFecha,
                            horaInicio: $lastTime,
                            horaFin: $t
                        );
                    }
                }
            }

            $current += $ev['d'];
            $lastTime = $t;
            $lastFecha = $currentFecha;
        }

        return $intervals;
    }

    private static function GetOthersFromGrupoIds(array $grupoIds): Collection
    {
        return EloquentBloqueHorario::with('aula')
            ->whereNotIn('grupo_curso_id', $grupoIds)
            ->get()
            ->map(fn ($bloque) => new OtherHorarioDTO(
                fechaOrDia: Dia::fromString($bloque->dia),
                horaInicio: Hora::fromString($bloque->horaInicio),
                horaFin: Hora::fromString($bloque->horaFin),
                aula: $bloque->aula->nombre,
            ))->merge(
                EloquentSesion::with('aula')
                    ->whereNotIn('grupo_curso_id', $grupoIds)
                    ->get()
                    ->map(fn ($sesion) => new OtherHorarioDTO(
                        fechaOrDia: Fecha::fromString($sesion->fecha),
                        horaInicio: Hora::fromString($sesion->horaInicio),
                        horaFin: Hora::fromString($sesion->horaFin),
                        aula: $sesion->aula->nombre,
                    ))
            )
            ->unique(fn (OtherHorarioDTO $x) => $x->uniqueKey());
    }

    private static function AreSameDate($fechaA, $fechaB): bool
    {
        [$carbonA, $carbonB] = self::NormalizeDates($fechaA, $fechaB);

        return $carbonA->format('Y-m-d') === $carbonB->format('Y-m-d');
    }

    private static function NormalizeDates(Fecha|Dia $fechaA, Fecha|Dia $fechaB)
    {
        if ($fechaA instanceof Fecha && $fechaB instanceof Dia) {
            $carbonA = $fechaA->toCarbon();
            $carbonB = $fechaB->toCarbonWithDate($carbonA);
        } elseif ($fechaA instanceof Dia && $fechaB instanceof Fecha) {
            $carbonA = $fechaA->toCarbonWithDate($fechaB->toCarbon());
            $carbonB = $fechaB->toCarbon();
        } elseif ($fechaA instanceof Fecha && $fechaB instanceof Fecha) {
            $carbonA = $fechaA->toCarbon();
            $carbonB = $fechaB->toCarbon();
        } elseif ($fechaA instanceof Dia && $fechaB instanceof Dia) {
            $today = now();
            $carbonA = $fechaA->toCarbonWithDate($today);
            $carbonB = $fechaB->toCarbonWithDate($today);
        }

        return [$carbonA, $carbonB];
    }

    /*public function getOwnHorarioAndOthers(array $grupoIds): HorarioDTO {
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
    }*/
}
