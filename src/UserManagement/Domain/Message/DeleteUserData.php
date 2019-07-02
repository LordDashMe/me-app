<?php

namespace UserManagement\Domain\Message;

class DeleteUserData 
{
    public $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
