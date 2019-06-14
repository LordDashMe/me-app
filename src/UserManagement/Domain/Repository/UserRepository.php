<?php

namespace UserManagement\Domain\Repository;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;

interface UserRepository
{
    public function create(User $user): void;

    public function update(User $user): void;

    public function get(UserId $id);

    public function getDataTable($options): array;

    public function softDelete(UserId $id): string;

    public function getByUserName(UserName $userName);

    public function isApproved(UserName $userName): bool;

    public function isRegistered(UserName $userName): bool;
}
