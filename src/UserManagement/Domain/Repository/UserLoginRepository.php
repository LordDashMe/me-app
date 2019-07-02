<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserLogin;

interface UserLoginRepository
{
    public function get(UserLogin $userLogin);
    
    public function isApproved(UserLogin $userLogin): bool;
}
