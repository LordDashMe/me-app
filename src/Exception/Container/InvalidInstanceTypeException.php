<?php

namespace LordDashMe\MeApp\Exception\Container;

use LordDashMe\MeApp\Exception\Container\ContainerException;

class InvalidInstanceTypeException extends ContainerException
{
    const IS_NOT_CLOSURE = 1;

    public static function isNotClosure(
        $message = 'The make closure can not build if the given instance is not a closure type.',
        $code = InvalidInstanceTypeException::IS_NOT_CLOSURE,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }  
}
