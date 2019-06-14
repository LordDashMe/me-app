<?php

namespace DomainCommon\Infrastructure\Service;

use Ramsey\Uuid\Uuid;

use DomainCommon\Domain\Service\UniqueIDResolver;

class UniqueIDResolverImpl implements UniqueIDResolver
{
    public function generate(): string
    {
        return Uuid::uuid4();
    }
}
