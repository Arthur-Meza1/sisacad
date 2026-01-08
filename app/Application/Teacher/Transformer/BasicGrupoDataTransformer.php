<?php

namespace App\Application\Teacher\Transformer;

use App\Application\Shared\DTOs\GrupoCursoDTO;

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
                'curso_id' => $dto->cursoId->getValue(),
                'nombre' => $dto->nombre,
                'tipo' => $dto->tipo,
                'turno' => $dto->turno,
                'cantidad' => $dto->nregistros,
            ];
        }

        return $res;
    }
}
