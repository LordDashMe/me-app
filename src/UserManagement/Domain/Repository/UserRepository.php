<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Username;

interface UserRepository
{
    public function create(User $user);

    public function update($id, User $user);

    public function get($id);

    public function softDelete($id);

    public function isApproved(Username $username);

    public function isRegistered(Username $username);
}
