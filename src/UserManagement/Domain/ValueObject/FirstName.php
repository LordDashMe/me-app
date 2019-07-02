<?php

namespace UserManagement\Domain\ValueObject;

class FirstName
{
    private $firstName;
    
    public function __construct(string $firstName)
    {
        $this->firstName = $firstName;
    }

    public function __toString()
    {
        return $this->firstName;
    }
}
