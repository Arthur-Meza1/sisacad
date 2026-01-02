<?php

namespace App\Application\Student\Transformer;

use App\Domain\Shared\Entity\GrupoCurso;

class GrupoCursoTransformer
{
    /**
     * @param  GrupoCurso[]  $cursos
     */
    public static function toArray(array $cursos): array
    {
        $res = [];

        foreach ($cursos as $curso) {
            $res[] = [
                'id' => $curso->id()->getValue(),
                'nombre' => $curso->curso()->nombre(),
                'turno' => $curso->grupoTurno()->getValue(),
                'tipo' => $curso->cursoTipo()->getValue(),
                'docente' => $curso->docente(),
            ];
        }

        return $res;
    }
}
