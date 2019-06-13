<?php

namespace UserManagement\Domain\Exception;

use Exception;

class PasswordException extends Exception
{
    const INVALID_FORMAT = 1;

    public static function invalidFormat(): PasswordException 
    {
        $message = 'The given password format is invalid.';
        $code = self::INVALID_FORMAT;

        return new self($message, $code, null);
    }
}
