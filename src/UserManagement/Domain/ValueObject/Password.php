<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Exception\PasswordException;

class Password
{
    /** 
     * Password must contain a minimum of 8 characters, 
     * 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.
     */
    const STANDARD_FORMAT = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/])[A-Za-z\d$@$!%*#?&*()_+|<>:\";\'~=`{}~\^\-\[\]\\\,\.\/]{8,}$/';

    private $password;
    
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function required()
    {
        if (empty($this->password)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Password');
        }      
    }

    public function validateStandardFormat()
    {
        if (! \preg_match(Password::STANDARD_FORMAT, $this->password)) {
            throw PasswordException::invalidFormat();
        }
    }

    public function get()
    {
        return $this->password;
    }
}
