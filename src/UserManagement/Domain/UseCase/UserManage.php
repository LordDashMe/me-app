<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Exception\UserManageFailedException;

class UserManage
{
    protected function validateUserIdIsNotEmpty($userId)
    {
        if (empty($userId)) {
            throw UserManageFailedException::userIdIsEmpty();
        }
    }
}
