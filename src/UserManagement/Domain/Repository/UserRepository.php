<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\ValueObject\UserId;

interface UserRepository
{
    public function getById(UserId $userId);
}
