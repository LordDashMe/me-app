<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class UserRole
{
    private $userRole;
    
    public function __construct($userRole = '')
    {
        $this->userRole = $this->evaluateStatus($userRole);
    }

    private function evaluateStatus()
    {
        switch ($this->userRole) {
            case User::ROLE_ADMIN:
            case User::ROLE_EDITOR:
            case User::ROLE_MEMBER:
                return $this->userRole;
            default:
                return User::ROLE_MEMBER;
        }
    }

    public function get()
    {
        return $this->userRole;
    }
}
