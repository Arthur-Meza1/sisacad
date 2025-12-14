<?php

namespace App\Application\Student\Transformer;

use App\Application\Shared\DTOs\BloqueHorarioDTO;
use App\Application\Shared\DTOs\HorarioDTO;
use App\Application\Shared\DTOs\OtherHorarioDTO;
use App\Domain\Shared\ValueObject\Dia;
use App\Domain\Shared\ValueObject\Fecha;

class HorarioTransformer {
  public static function toArray(HorarioDTO $dto): array {
    return [
      "horario" => self::bloqueHorarioToArray($dto->horario),
      "sesiones" => self::bloqueHorarioToArray($dto->sesiones),
    ];
  }

  private static function bloqueHorarioToArray(array $dtos): array {
    $res = [];

    foreach ($dtos as $dto ) {
      $val = [
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

      if($dto->fechaOrDia instanceof Fecha) {
        $val['fecha'] = $dto->fechaOrDia->toString();
      } else if($dto->fechaOrDia instanceof Dia) {
        $val['dia'] = $dto->fechaOrDia->toString();
      }

      $res[] = $val;
    }

    return $res;
  }
}
