<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserModification;
use UserManagement\Domain\ValueObject\UserId;

interface UserModificationRepository
{
    public function save(UserModification $userModification): UserId;
}
