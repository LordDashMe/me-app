<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\RegisterUser;

interface UserRegistrationRepository
{
    public function isUserNameAlreadyRegistered(string $userName): bool;
    
    public function save(RegisterUser $user): void;
}
