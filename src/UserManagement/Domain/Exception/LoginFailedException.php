<?php

namespace UserManagement\Domain\Exception;

use Exception;

class LoginFailedException extends Exception
{
    const INVALID_ACCOUNT = 1;
    const USER_STATUS_IS_NOT_ACTIVE = 2;

    public static function invalidAccount(): LoginFailedException
    {
        $message = 'Invalid account.';
        $code = self::INVALID_ACCOUNT;

        return new self($message, $code, null);
    }

    public static function userStatusIsNotActive(): LoginFailedException
    {
        $message = 'The account status is inactive.';
        $code = self::USER_STATUS_IS_NOT_ACTIVE;

        return new self($message, $code, null);
    }
}
