<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserRegistration;

interface UserRegistrationRepository
{
    public function isUserNameAlreadyRegistered(UserRegistration $userRegistration): bool;
    
    public function save(UserRegistration $userRegistration): void;
}
