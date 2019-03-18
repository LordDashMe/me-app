<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Exception\UserManageFailedException;

class ManageUser
{
    protected function validateUserIdIsNotEmpty($userId)
    {
        if (empty($userId)) {
            throw UserManageFailedException::userIdIsEmpty();
        }
    }
}
