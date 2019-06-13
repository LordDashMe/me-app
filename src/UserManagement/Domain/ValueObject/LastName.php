<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

class LastName
{
    private $lastName;
    
    public function __construct($lastName)
    {
        $this->lastName = $lastName;
    }

    public function required()
    {
        if (empty($this->lastName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Last Name');
        }      
    }

    public function get()
    {
        return $this->lastName;
    }
}
