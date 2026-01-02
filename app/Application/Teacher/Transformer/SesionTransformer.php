<?php

namespace App\Application\Teacher\Transformer;

use App\Domain\Shared\Entity\Asistencia;
use App\Domain\Shared\Entity\Sesion;

class SesionTransformer
{
    public static function toArray(Sesion $sesion): array
    {
        return [
            'id' => $sesion->id()->getValue(),
            'editable' => $sesion->editable(),
            'asistencias' => self::asistenciaToArray($sesion->asistencias()),
        ];
    }

    /**
     * @param  Asistencia[]  $asistencias
     */
    private static function asistenciaToArray(array $asistencias): array
    {
        $res = [];

        foreach ($asistencias as $asistencia) {
            $res[] = [
                'alumno' => [
                    'id' => $asistencia->alumnoId()->getValue(),
                    'nombre' => $asistencia->alumnoNombre(),
                ],
                'presente' => $asistencia->estado()->isPresente() ? 1 : 0,
            ];
        }

        return $res;
    }
}
