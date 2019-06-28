<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserModification;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;

interface UserModificationRepository
{
    public function save(UserModification $user): void;
    
    public function softDelete(string $userId): string;
}
