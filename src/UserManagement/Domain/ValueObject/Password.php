<?php

namespace UserManagement\Domain\ValueObject;

class Password
{
    const STANDARD_FORMAT = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/])[A-Za-z\d$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/]{8,}$/';

    private $password;
    
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function isValid()
    {
        // Password must contain a minimum of 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.
        return \preg_match(Password::STANDARD_FORMAT, $this->password);
    }

    public function get()
    {
        return $this->password;
    }
}
