<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Exception\UserNameException;

class UserName
{
    const MAX_CHARACTER_LENGTH = 255;

    private $userName;
    
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function required()
    {
        if (empty($this->userName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('User Name');
        }      
    }

    public function validateCharacterLength()
    {
        if (\strlen($this->userName) > self::MAX_CHARACTER_LENGTH) {
            throw UserNameException::exceededTheMaxCharacterLength();
        }
    }

    public function get()
    {
        return $this->userName;
    }
}
