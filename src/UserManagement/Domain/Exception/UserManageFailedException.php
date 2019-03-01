<?php

namespace UserManagement\Domain\Exception;

use Exception;

class UserManageFailedException extends Exception
{
    const USER_ID_IS_EMPTY = 1;

    public static function userIdIsEmpty($previous = null) 
    {
        $message = 'The given user id is empty.';
        $code = self::USER_ID_IS_EMPTY;

        return new self($message, $code, $previous);
    }
}
