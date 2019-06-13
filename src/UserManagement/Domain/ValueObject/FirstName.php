<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

class FirstName
{
    private $firstName;
    
    public function __construct($firstName)
    {
        $this->firstName = $firstName;
    }

    public function required()
    {
        if (empty($this->firstName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('First Name');
        }      
    }

    public function get()
    {
        return $this->firstName;
    }
}
