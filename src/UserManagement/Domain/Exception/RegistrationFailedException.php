<?php

namespace UserManagement\Domain\Exception;

use Exception;

class RegistrationFailedException extends Exception
{
    const INVALID_EMAIL_FORMAT = 1;
    const USERNAME_ALREADY_REGISTERED = 2;
    const INVALID_PASSWORD_FORMAT = 3;
    const CONFIRMATION_PASSWORD_NOT_MATCHED = 4;

    public static function invalidEmailFormat($previous = null) 
    {
        $message = 'The given email format is invalid.';
        $code = static::INVALID_EMAIL_FORMAT;

        return new static($message, $code, $previous);
    }

    public static function usernameAlreadyRegistered($previous = null) 
    {
        $message = 'The username already registered.';
        $code = static::USERNAME_ALREADY_REGISTERED;

        return new static($message, $code, $previous);
    }

    public static function invalidPasswordFormat($previous = null) 
    {
        $message = 'The given password format is invalid.';
        $code = static::INVALID_PASSWORD_FORMAT;

        return new static($message, $code, $previous);
    }

    public static function confirmationPasswordNotMatched($previous = null) 
    {
        $message = 'The confirmation password not matched.';
        $code = static::CONFIRMATION_PASSWORD_NOT_MATCHED;

        return new static($message, $code, $previous);
    }
}
