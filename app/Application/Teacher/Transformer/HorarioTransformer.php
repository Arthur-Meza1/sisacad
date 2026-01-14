<?php

namespace App\Application\Teacher\Transformer;

use App\Application\Shared\DTOs\HorarioDTO;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;

class HorarioTransformer
{
    public static function toArray(HorarioDTO $dto): array
    {
        return [
            'horario' => self::bloqueHorarioToArray($dto->horario),
            'sesiones' => self::bloqueHorarioToArray($dto->sesiones),
            'occupied' => self::occupiedSlotToArray($dto->occupied),
        ];
    }

    private static function bloqueHorarioToArray(array $dtos): array
    {
        $res = [];

        foreach ($dtos as $dto) {
            $val = [
                'id' => $dto->id->getValue(),
                'grupo' => [
                    'id' => $dto->grupoId->getValue(),
                    'nombre' => $dto->grupoNombre,
                ],
                'aula' => [
                    'id' => $dto->aulaId->getValue(),
                    'nombre' => $dto->aulaNombre,
                ],
                'tipo' => $dto->tipo->getValue(),
                'turno' => $dto->turno->getValue(),
                'horaInicio' => $dto->horaInicio->toString(),
                'horaFin' => $dto->horaFin->toString(),
            ];

            if ($dto->fechaOrDia instanceof Fecha) {
                $val['fecha'] = $dto->fechaOrDia->toString();
            } elseif ($dto->fechaOrDia instanceof Dia) {
                $val['dia'] = $dto->fechaOrDia->toString();
            }

            $res[] = $val;
        }

        return $res;
    }

    private static function occupiedSlotToArray(array $dtos): array
    {
        $res = [];

        foreach ($dtos as $dto) {
            $val = [
                'fecha' => $dto->fechaOrDia->toString(),
                'horaInicio' => $dto->horaInicio->toString(),
                'horaFin' => $dto->horaFin->toString(),
                'from_bloque' => $dto->fechaOrDia instanceof Dia,
            ];

            $res[] = $val;
        }

        return $res;
    }
}
