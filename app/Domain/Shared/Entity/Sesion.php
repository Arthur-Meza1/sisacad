<?php

namespace App\Domain\Shared\Entity;

use App\Application\Shared\DTOs\SesionDTO;
use App\Domain\Shared\Repository\IAsistenciaRepository;
use App\Domain\Shared\ValueObject\Id;

class Sesion {
  private function __construct(
    public readonly Id $id,
    public readonly SesionDTO $dto,
    public array $asistencias = []
  ) {}

  public static function create(Id $id, SesionDTO $dto): Sesion {
    return new self($id, $dto);
  }

  public function addAsistencia(Asistencia $asistencia): void {
    $this->asistencias[] = $asistencia;
  }

  public function generarAsistencias(array $alumnos, IAsistenciaRepository $repo): void {
    foreach ($alumnos as $alumno) {
      $asistencia = Asistencia::create(
        sesionId: $this->id,
        alumnoId: $alumno['id'],
        alumnoNombre: $alumno['nombre'],
        status: false
      );
      $repo->save($asistencia);
      $this->addAsistencia($asistencia);
    }
  }
}
