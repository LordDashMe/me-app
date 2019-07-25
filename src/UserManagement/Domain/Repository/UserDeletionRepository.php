<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserDeletion;
use UserManagement\Domain\ValueObject\UserId;

interface UserDeletionRepository
{
    public function save(UserDeletion $userDeletion): UserId;
}
