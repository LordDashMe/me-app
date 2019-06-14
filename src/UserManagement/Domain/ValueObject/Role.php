<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class Role
{
    private $role;
    
    public function __construct($role = '')
    {
        $this->role = $this->getUserRole($role);
    }

    private function getUserRole()
    {
        switch ($this->role) {
            case User::ROLE_ADMIN:
            case User::ROLE_EDITOR:
            case User::ROLE_MEMBER:
                return $this->role;
            default:
                return User::ROLE_MEMBER;
        }
    }

    public function get()
    {
        return $this->role;
    }
}
