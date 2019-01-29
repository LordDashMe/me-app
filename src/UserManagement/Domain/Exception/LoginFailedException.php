<?php

namespace UserManagement\Domain\Exception;

use Exception;

class LoginFailedException extends Exception
{
    const INVALID_ACCOUNT = 1;
    const USER_STATUS_IS_NOT_ACTIVE = 2;

    public static function invalidAccount($previous = null) 
    {
        $message = 'Invalid account.';
        $code = static::INVALID_ACCOUNT;

        return new static($message, $code, $previous);
    }

    public static function userStatusIsNotActive($previous = null) 
    {
        $message = 'The account status is inactived.';
        $code = self::USER_STATUS_IS_NOT_ACTIVE;

        return new self($message, $code, $previous);
    }
}
