<?php

namespace UserManagement\Domain\Exception;

use Exception;

class EmailException extends Exception
{
    const INVALID_FORMAT = 1;
    const EXCEEDED_MAX_CHARACTER_LENGTH = 2;

    public static function invalidFormat(): EmailException 
    {
        $message = 'The given email format is invalid.';
        $code = self::INVALID_FORMAT;

        return new self($message, $code, null);
    }

    public static function exceededTheMaxCharacterLength(): EmailException
    {
        $message = 'The email was exceeded the allowed max character length.';
        $code = self::EXCEEDED_MAX_CHARACTER_LENGTH;

        return new self($message, $code, null);
    }
}
