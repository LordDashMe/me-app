<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Exception\ManageUserFailedException;

class ManageUser
{
    protected function validateUserIdIsNotEmpty($userId)
    {
        if (empty($userId->get())) {
            throw ManageUserFailedException::userIdIsEmpty();
        }
    }
}
