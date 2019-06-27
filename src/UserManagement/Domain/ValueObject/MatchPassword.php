<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Service\PasswordEncoder;

class MatchPassword
{
    private $passwordEncoder;

    private $encodedPassword;
    private $plainTextPassword;
    
    public function __construct(
        PasswordEncoder $passwordEncoder, 
        string $encodedPassword, 
        string $plainTextPassword
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->encodedPassword = $encodedPassword;
        $this->plainTextPassword = $plainTextPassword;
    }

    public function isMatch(): bool
    {
        return $this->passwordEncoder->verifyEncodedText(
            $this->encodedPassword, $this->plainTextPassword, $this->plainTextPassword
        );
    }
}
