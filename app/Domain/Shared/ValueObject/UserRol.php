<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidRol;

final class UserRol
{
    public const STUDENT = 'student';

    public const TEACHER = 'teacher';

    /**
     * @throws InvalidRol
     */
    private function __construct(private readonly string $rol)
    {
        if (! in_array($rol, [self::STUDENT, self::TEACHER])) {
            throw InvalidRol::execute($rol);
        }
    }

    public static function fromString(string $rol): UserRol
    {
        return new self($rol);
    }

    private static function allowedRoles(): array
    {
        return [self::STUDENT, self::TEACHER];
    }

    public function getValue(): string
    {
        return $this->rol;
    }
}
