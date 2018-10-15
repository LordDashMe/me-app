<?php

namespace LordDashMe\MeApp\Exception\Route;

class RequestRouteNotResolvedException extends \Exception
{
    const IS_NOT_LISTED_IN_ROUTE_COLLECTION_BAG = 1;
    const IS_NOT_VALID_RETURN_INSTANCE = 2;

    public static function  isNotListedInRouteCollectionBag(
        $message = 'The given request route can not be resolved.',
        $code = RequestRouteNotResolvedException::IS_NOT_LISTED_IN_ROUTE_COLLECTION_BAG,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    }

    public static function  isNotValidReturnInstance(
        $message = 'The given request route can not be resolved because of invalid return instance value.',
        $code = RequestRouteNotResolvedException::IS_NOT_VALID_RETURN_INSTANCE,
        $previous = null
    ) {
        return new static($message, $code, $previous);
    } 
}
