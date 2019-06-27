<?php

namespace UserManagement\Domain\ValueObject;

use AppCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Exception\ConfirmPasswordException;

class ConfirmPassword
{
    private $confirmPassword;
    
    public function __construct(string $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function isMatch(string $password)
    {
        if ($password !== $this->confirmPassword) {
            throw ConfirmPasswordException::notMatched();
        }
    }
}
