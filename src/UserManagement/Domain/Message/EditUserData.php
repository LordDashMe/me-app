<?php

namespace UserManagement\Domain\Message;

class EditUserData 
{
    public $userId;
    public $firstName;
    public $lastName;
    public $email;
    public $status;

    public function __construct(
        string $userId,
        string $firstName, 
        string $lastName,
        string $email,
        string $status
    ) {
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->status = $status;
    }
}
