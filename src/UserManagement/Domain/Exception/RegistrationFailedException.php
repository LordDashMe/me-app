<?php

namespace UserManagement\Domain\Exception;

use Exception;

class RegistrationFailedException extends Exception
{
    const USERNAME_ALREADY_REGISTERED = 1;

    public static function userNameAlreadyRegistered(): RegistrationFailedException
    {
        $message = 'The username already registered.';
        $code = self::USERNAME_ALREADY_REGISTERED;

        return new self($message, $code, null);
    }
}
