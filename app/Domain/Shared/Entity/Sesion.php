<?php

namespace App\Domain\Shared\Entity;

use App\Domain\Shared\Exception\SesionCerrada;
use App\Domain\Shared\ValueObject\AsistenciaEstado;
use App\Domain\Shared\ValueObject\Fecha;
use App\Domain\Shared\ValueObject\Hora;
use App\Domain\Shared\ValueObject\Id;
use Carbon\Carbon;

final class Sesion
{
  private const AVAILABLE_MINUTES = 15;

  private function __construct(
    private readonly Carbon $fecha,
    private readonly Carbon $hora,
  ) {}

  public static function fromPrimitives(
    string $fecha,
    string $hora,
  ): self {
    return new self(
      self::parseFecha($fecha),
      self::parseHora($hora)
    );
  }

  public function isEditable(): bool
  {
    return $this->isWithinEditableWindow(
      $this->minutesFromSessionStart()
    );
  }

  private function minutesFromSessionStart(): int
  {
    return $this->sessionDateTime()
      ->diffInMinutes($this->now(), false);
  }

  private function sessionDateTime(): Carbon
  {
    return $this->fecha
      ->copy()
      ->setTimeFrom($this->hora);
  }

  private function isWithinEditableWindow(int $minutesDifference): bool
  {
    return $minutesDifference >= 0
      && $minutesDifference <= self::AVAILABLE_MINUTES;
  }

  private static function parseFecha(string $fecha): Carbon
  {
    return Carbon::createFromFormat('Y-m-d', $fecha);
  }

  private static function parseHora(string $hora): Carbon
  {
    return Carbon::createFromFormat('H:i', $hora);
  }

  private function now(): Carbon
  {
    return Carbon::now();
  }
}

