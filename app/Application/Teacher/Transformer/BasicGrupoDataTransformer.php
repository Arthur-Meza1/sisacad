<?php

namespace App\Application\Teacher\Transformer;

use App\Application\Teacher\DTOs\GrupoCursoDTO;

class BasicGrupoDataTransformer
{
    /**
     * @return GrupoCursoDTO[]
     */
    public static function toArray(array $dtos): array
    {
        $res = [];

        foreach ($dtos as $dto) {
            $res[] = [
                'id' => $dto->id->getValue(),
                'nombre' => $dto->nombre,
                'tipo' => $dto->tipo,
                'turno' => $dto->turno,
                'cantidad' => $dto->nregistros,
            ];
        }

        return $res;
    }
}
