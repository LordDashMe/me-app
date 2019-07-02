<?php

namespace UserManagement\Domain\ValueObject;

class UserId
{
    private $userId;
    
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function __toString()
    {
        return $this->userId;
    }
}
