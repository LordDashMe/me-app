<?php

namespace UserManagement\Domain\Exception;

class LoginFailedException extends \Exception
{
    const REQUIRED_FIELD_IS_EMPTY = 1;
    const INVALID_ACCOUNT = 2;
    const USER_STATUS_IS_NOT_ACTIVE = 3;

    public static function requiredFieldIsEmpty(
        $requiredField,
        $code = self::REQUIRED_FIELD_IS_EMPTY,
        $previous = null
    ) {
        $message = "The {$requiredField} field is empty.";

        return new self($message, $code, $previous);
    }

    public static function invalidAccount(
        $message = 'Invalid account.',
        $code = self::INVALID_ACCOUNT,
        $previous = null
    ) {
        return new self($message, $code, $previous);
    }

    public static function userStatusIsNotActive(
        $message = 'The account status is inactived.',
        $code = self::USER_STATUS_IS_NOT_ACTIVE,
        $previous = null
    ) {
        return new self($message, $code, $previous);
    }
}
