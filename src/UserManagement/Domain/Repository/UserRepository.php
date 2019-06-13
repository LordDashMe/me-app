<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;

interface UserRepository
{
    public function create(User $user);

    public function update(User $user);

    public function get(UserId $id);

    public function getDataTable($options);

    public function softDelete(UserId $id);

    public function getByUserName(UserName $userName);

    public function isApproved(UserName $userName);

    public function isRegistered(UserName $userName);
}
