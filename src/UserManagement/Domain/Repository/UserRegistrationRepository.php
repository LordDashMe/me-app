<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserRegistration;

interface UserRegistrationRepository
{
    public function isUserNameAlreadyRegistered(string $userName): bool;
    
    public function save(UserRegistration $user): void;
}
