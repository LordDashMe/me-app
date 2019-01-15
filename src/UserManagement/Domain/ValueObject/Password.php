<?php

namespace UserManagement\Domain\ValueObject;

class Password
{
    private $password;
    
    public function __construct($password = '')
    {
        $this->password = $password;
    }

    public function isInvalidFormat()
    {
        // TODO: Apply the regex in the condition, using the standard for Password.
        return ($this->password) ? false : true;
    }

    public function get()
    {
        return $this->password;
    }
}
