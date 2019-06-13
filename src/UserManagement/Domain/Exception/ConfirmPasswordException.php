<?php

namespace UserManagement\Domain\Exception;

use Exception;

class ConfirmPasswordException extends Exception
{
    const NOT_MATCHED = 1;

    public static function notMatched(): ConfirmPasswordException 
    {
        $message = 'The given confirmation password does not matched the given password.';
        $code = self::NOT_MATCHED;

        return new self($message, $code, null);
    }
}
