<?php

namespace UserManagement\Domain\ValueObject;

class UserId
{
    private $userId;
    
    public function __construct($userId = '')
    {
        $this->userId = $userId ?: \uniqid();
    }

    public function get()
    {
        return $this->userId;
    }
}
