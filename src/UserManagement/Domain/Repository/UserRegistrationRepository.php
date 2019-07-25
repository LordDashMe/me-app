<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\ValueObject\UserName;

interface UserRegistrationRepository
{
    public function isUserNameAlreadyRegistered(UserRegistration $userRegistration): bool;
    
    public function save(UserRegistration $userRegistration): UserName;
}
