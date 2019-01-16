<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\ValueObject\Password;

class MatchPassword
{
    private $password;
    private $confirmPassword;
    
    public function __construct(Password $password, $confirmPassword = '')
    {
        $this->password = $password->get();
        $this->confirmPassword = $confirmPassword;
    }

    public function isEqual()
    {
        return ($this->password === $this->confirmPassword);
    }
}
