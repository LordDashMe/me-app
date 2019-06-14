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
        $this->password = $password->get();
        $this->confirmPassword = $confirmPassword;
    }

    public function required()
    {
        if (empty($this->confirmPassword)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Confirm Password');
        }      
    }

    public function validateIsMatch()
    {
        if ($this->password !== $this->confirmPassword) {
            throw ConfirmPasswordException::notMatched();
        }
    }
}
