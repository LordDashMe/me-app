<?php

namespace UserManagement\Domain\Message;

class UserRegistrationData 
{
    public $firstName;
    public $lastName;
    public $email;
    public $userName;
    public $password;
    public $confirmPassword;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $userName,
        string $password,
        string $confirmPassword
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;    
    }
}
