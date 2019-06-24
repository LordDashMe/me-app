<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Exception\ConfirmPasswordException;
use UserManagement\Domain\ValueObject\Password;

class ConfirmPassword
{
    private $password;
    private $confirmPassword;
    
    public function __construct(Password $password, string $confirmPassword)
    {
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function validateIsMatch()
    {
        if ($this->password !== $this->confirmPassword) {
            throw ConfirmPasswordException::notMatched();
        }
    }
}
