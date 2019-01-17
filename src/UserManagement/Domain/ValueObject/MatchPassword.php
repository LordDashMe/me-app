<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\Service\PasswordEncoder;

class MatchPassword
{
    private $passwordEncoder;
    private $password;
    private $encodedPassword;
    
    public function __construct(PasswordEncoder $passwordEncoder, $encodedPassword, Password $password)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->encodedPassword = $encodedPassword;
        $this->password = $password->get();
    }

    public function isMatch()
    {
        return $this->passwordEncoder->verifyEncodedText($this->encodedPassword, $this->password);
    }
}
