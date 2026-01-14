<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidValue;

use function PHPUnit\Framework\isEmpty;

class NonNullString
{
    private function __construct(
        private readonly string $content,
    ) {
        if (isempty($this->content)) {
            throw InvalidValue::stringNullOrEmpty();
        }
    }

    /**
     * @throws InvalidValue
     */
    public static function fromString(string $content): self
    {
        return new self($content);
    }
}
