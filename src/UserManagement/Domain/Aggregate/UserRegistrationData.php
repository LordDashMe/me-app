<?php

namespace UserManagement\Domain\Aggregate;

use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\ConfirmPassword;

class UserRegistrationData 
{
    public $firstName;
    public $lastName;
    public $email;
    public $userName;
    public $password;
    public $confirmPassword;

    public function __construct(
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $userName,
        Password $password,
        ConfirmPassword $confirmPassword
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;    
    }
}
