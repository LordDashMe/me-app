<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\ValueObject\Password;

class MatchPassword
{
    private $passwordEncoder;
    private $password;
    private $encodedPassword;
    
    public function __construct(
        PasswordEncoder $passwordEncoder, 
        string $encodedPassword, 
        Password $password
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->encodedPassword = $encodedPassword;
        $this->password = $password->get();
    }

    public function isMatch(): bool
    {
        return $this->passwordEncoder->verifyEncodedText(
            $this->encodedPassword, $this->password, $this->password
        );
    }
}
