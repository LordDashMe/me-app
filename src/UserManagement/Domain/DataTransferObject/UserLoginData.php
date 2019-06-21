<?php

namespace UserManagement\Domain\DataTransferObject;

use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;

class UserLoginData 
{
    public $userName;
    public $password;

    public function __construct(UserName $userName, Password $password) 
    {
        $this->userName = $userName;
        $this->password = $password; 
    }
}
