<?php

namespace App\Domain\Shared\Exception;

class UserNotFound extends \Exception
{
    public static function execute(): self
    {
        return new self('User not found');
    }
}
