<?php

namespace UserManagement\Domain\Message;

class UserLoginData 
{
    public $userName;
    public $password;

    public function __construct(string $userName, string $password) 
    {
        $this->userName = $userName;
        $this->password = $password; 
    }
}
