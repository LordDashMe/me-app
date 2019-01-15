<?php

namespace UserManagement\Domain\ValueObject;

class Username
{
    private $username;
    
    public function __construct($username = '')
    {
        $this->username = $username;
    }

    public function get()
    {
        return $this->username;
    }
}
