<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class Status
{
    private $status;
    
    public function __construct(string $status = '')
    {
        $this->status = $status;
    }

    public function __toString()
    {
        switch ($this->status) {
            case User::STATUS_ACTIVE:
                return User::STATUS_ACTIVE;
            case User::STATUS_INACTIVE:
            default:
                return User::STATUS_INACTIVE;
        }
    }
}
