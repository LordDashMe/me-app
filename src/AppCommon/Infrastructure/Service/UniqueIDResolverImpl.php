<?php

namespace AppCommon\Infrastructure\Service;

use Ramsey\Uuid\Uuid;

use AppCommon\Domain\Service\UniqueIDResolver;

class UniqueIDResolverImpl implements UniqueIDResolver
{
    public function generate(): string
    {
        return Uuid::uuid4();
    }
}
