<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Exception\EmailException;

class Email
{
    const MAX_CHARACTER_LENGTH = 255;

    private $email;
    
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function required()
    {
        if (empty($this->email)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Email');
        }      
    }

    public function validateFormat()
    {
        if (! \filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw EmailException::invalidFormat();
        }
    }

    public function validateCharacterLength() 
    {
        if (\strlen($this->email) > self::MAX_CHARACTER_LENGTH) {
            throw EmailException::exceededTheMaxCharacterLength();
        }
    }

    public function get()
    {
        return $this->email;
    }
}
