<?php

namespace UserManagement\Domain\Exception;

class RegistrationFailedException extends \Exception
{
    const REQUIRED_FIELD_IS_EMPTY = 1;
    const INVALID_EMAIL_FORMAT = 2;
    const USERNAME_ALREADY_REGISTERED = 3;
    const INVALID_PASSWORD_FORMAT = 4;
    const CONFIRMATION_PASSWORD_NOT_MATCHED = 5;

    public static function requiredFieldIsEmpty(
        $requiredField,
        $code = self::REQUIRED_FIELD_IS_EMPTY,
        $previous = null
    ) {
        $message = "The {$requiredField} field is empty.";

        return new static($message, $code, $previous);
    }

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
