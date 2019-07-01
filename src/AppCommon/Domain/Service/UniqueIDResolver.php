<?php

namespace AppCommon\Domain\Service;

interface UniqueIDResolver
{
    public function generate(): string;
}
