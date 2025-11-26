<?php

namespace App\Application\Teacher\Transformer;

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
      "others" => self::otherToArray($dto->otros),
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
        'horaInicio' => $dto->horaInicio->getValue(),
        'horaFin' => $dto->horaFin->getValue(),
      ];

      if($dto->fechaOrDia instanceof Fecha) {
        $val['fecha'] = $dto->fechaOrDia->getValue();
      } else if($dto->fechaOrDia instanceof Dia) {
        $val['dia'] = $dto->fechaOrDia->getValue();
      }

      $res[] = $val;
    }

    return $res;
  }

  private static function otherToArray(array $dtos): array {
    $res = [];

    foreach ($dtos as $dto ) {
      $val = [
        'fecha' => $dto->fechaOrDia->getValue(),
        'aula' => $dto->aula,
        'horaInicio' => $dto->horaInicio->getValue(),
        'horaFin' => $dto->horaFin->getValue(),
        'from_bloque' => $dto->fromBloque,
      ];

      $res[] = $val;
    }

    return $res;
  }
}
