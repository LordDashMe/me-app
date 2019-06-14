<?php

namespace UserManagement\Domain\ValueObject;

class UserId
{
    private $userId;
    
    public function __construct($userId = '')
    {
        $this->userId = $userId;
    }

    public function get()
    {
        return $this->userId;
    }
}
