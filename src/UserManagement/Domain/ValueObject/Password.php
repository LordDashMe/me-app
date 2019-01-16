<?php

namespace UserManagement\Domain\ValueObject;

class Password
{
    const STANDARD_FORMAT = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/])[A-Za-z\d$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/]{8,}$/';

    private $password;
    
    public function __construct($password = '')
    {
        $this->password = $password;
    }

    public function isValid()
    {
        return \preg_match(Password::STANDARD_FORMAT, $this->password);
    }

    public function get()
    {
        return $this->password;
    }
}
