<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\UserDeletion;

interface UserDeletionRepository
{
    public function save(UserDeletion $userDeletion);
}
