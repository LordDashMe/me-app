<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Entity\User;

class Role
{
    private $role;
    
    public function __construct(string $role = '')
    {
        $this->role = $this->getUserRole($role);
    }

    private function getUserRole(string $role): string
    {
        switch ($role) {
            case User::ROLE_ADMIN:
            case User::ROLE_EDITOR:
            case User::ROLE_MEMBER:
                return $role;
            default:
                return User::ROLE_MEMBER;
        }
    }

    public function get(): string
    {
        return $this->role;
    }
}
