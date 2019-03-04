<?php

namespace UserManagement\Domain\Exception;

use Exception;

class LogoutFailedException extends Exception
{
    const NO_USER_SESSION_FOUND = 1;

    public static function noUserSessionFound($previous = null) 
    {
        $message = 'No user session found.';
        $code = self::NO_USER_SESSION_FOUND;

        return new self($message, $code, $previous);
    }
}
