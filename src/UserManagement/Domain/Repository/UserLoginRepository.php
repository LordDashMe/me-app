<?php

namespace UserManagement\Domain\Repository;

interface UserLoginRepository
{
    public function getByUserName(string $userName);
    
    public function isApproved(string $userName): bool;
}
