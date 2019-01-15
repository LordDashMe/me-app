<?php

namespace UserManagement\Domain\Entity;

use Exception;

class RegistrationFailedException extends Exception
{
    const INVALID_PASSWORD_FORMATTED = 1;

    public static function invalidPasswordFormatted(
        $message = 'The given password formatted is invalid.',
        $code = self::INVALID_PASSWORD_FORMATTED,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }
}
