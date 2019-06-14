<?php

namespace DomainCommon\Domain\Exception;

use Exception;

class RequiredFieldException extends Exception
{
    const REQUIRED_FIELD_IS_EMPTY = 1;

    public static function requiredFieldIsEmpty($requiredField, $previous = null): RequiredFieldException
    {
        $message = "The {$requiredField} field is empty.";
        $code = static::REQUIRED_FIELD_IS_EMPTY;

        return new static($message, $code, $previous);
    }
}
