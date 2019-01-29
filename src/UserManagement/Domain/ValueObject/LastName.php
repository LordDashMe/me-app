<?php

namespace UserManagement\Domain\ValueObject;

class LastName
{
    private $lastName;
    
    public function __construct($lastName)
    {
        $this->lastName = $lastName;
    }

    public function get()
    {
        return $this->lastName;
    }
}
