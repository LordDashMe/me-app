<?php

namespace DomainCommon\Domain\ValueObject;

class CreatedAt
{
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    private $createdAt;
    
    public function __construct(string $createdAt = '')
    {
        $this->createdAt = $createdAt ?: \date(self::MYSQL_DATETIME_FORMAT);
    }

    public function get(): string
    {
        return $this->createdAt;
    }
}
