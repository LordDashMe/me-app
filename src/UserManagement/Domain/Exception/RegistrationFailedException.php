<?php

namespace UserManagement\Domain\Exception;

class RegistrationFailedException extends \Exception
{
    const INVALID_EMAIL_FORMAT = 1;
    const USERNAME_ALREADY_REGISTERED = 2;
    const INVALID_PASSWORD_FORMAT = 3;
    const CONFIRMATION_PASSWORD_NOT_MATCHED = 4;

    public static function invalidEmailFormat(
        $message = 'The given email format is invalid.',
        $code = self::INVALID_EMAIL_FORMAT,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }

    public static function usernameAlreadyRegistered(
        $message = 'The username already registered.',
        $code = self::USERNAME_ALREADY_REGISTERED,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }

    public static function invalidPasswordFormat(
        $message = 'The given password format is invalid.',
        $code = self::INVALID_PASSWORD_FORMAT,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }

    public static function confirmationPasswordNotMatched(
        $message = 'The confirmation password not matched.',
        $code = self::CONFIRMATION_PASSWORD_NOT_MATCHED,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }
}
