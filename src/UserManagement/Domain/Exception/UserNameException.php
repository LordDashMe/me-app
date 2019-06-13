<?php

namespace UserManagement\Domain\Exception;

use Exception;

class UserNameException extends Exception
{
    const EXCEEDED_MAX_CHARACTER_LENGTH = 1;

    public static function exceededTheMaxCharacterLength(): UserNameException
    {
        $message = 'The username was exceeded the allowed max character length.';
        $code = self::EXCEEDED_MAX_CHARACTER_LENGTH;

        return new self($message, $code, null);
    }
}
