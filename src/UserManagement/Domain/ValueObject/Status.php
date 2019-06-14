<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class Status
{
    private $status;
    
    public function __construct($status = '')
    {
        $this->status = $this->getUserStatus($status);
    }

    private function getUserStatus()
    {
        switch ($this->status) {
            case User::STATUS_ACTIVE:
            case User::STATUS_INACTIVE:
                return $this->status;
            default:
                return User::STATUS_INACTIVE;
        }
    }

    public function get()
    {
        return $this->status;
    }
}
