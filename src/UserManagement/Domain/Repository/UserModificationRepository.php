<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserModification;

interface UserModificationRepository
{
    public function save(UserModification $userModification): void;
    
    public function softDelete(string $userId): string;
}
