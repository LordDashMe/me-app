<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;

interface UserRepository
{
    public function create(User $user);

    public function update(UserId $id, User $user);

    public function get(UserId $id);

    public function softDelete(UserId $id);

    public function isApproved(Username $username);
}
