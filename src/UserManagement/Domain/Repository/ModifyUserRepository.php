<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\ModifyUser;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;

interface ModifyUserRepository
{
    public function save(ModifyUser $user): void;
    
    public function softDelete(string $userId): string;
}
