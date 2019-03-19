<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class UserStatus
{
    private $userStatus;
    
    public function __construct($userStatus = '')
    {
        $this->userStatus = $this->evaluateStatus($userStatus);
    }

    private function evaluateStatus()
    {
        switch ($this->userStatus) {
            case User::STATUS_ACTIVE:
            case User::STATUS_INACTIVE:
                return $this->userStatus;
            default:
                return User::STATUS_INACTIVE;
        }
    }

    public function get()
    {
        return $this->userStatus;
    }
}
