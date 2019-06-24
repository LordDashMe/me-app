<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\ValueObject\UserName;

interface UserRegistrationRepository
{
    public function isRegistered(UserName $userName): bool;

    public function save(UserRegistration $user): void;
}
