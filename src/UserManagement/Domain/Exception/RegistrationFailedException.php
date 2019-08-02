<?php

namespace UserManagement\Domain\Exception;

use Exception;

class RegistrationFailedException extends Exception
{
    const USERNAME_ALREADY_REGISTERED = 1;

    public static function userNameAlreadyRegistered(): RegistrationFailedException
    {
        $message = 'Something happen when saving, please try again.';
        $code = self::USERNAME_ALREADY_REGISTERED;

        return new self($message, $code, null);
    }
}
