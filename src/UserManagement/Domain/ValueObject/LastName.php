<?php

namespace UserManagement\Domain\ValueObject;

use DomainCommon\Domain\Exception\RequiredFieldException;

class LastName
{
    private $lastName;
    
    public function __construct(string $lastName)
    {
        $this->lastName = $lastName;
    }

    public function required()
    {
        if (empty($this->lastName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Last Name');
        }      
    }

    public function get(): string
    {
        return $this->lastName;
    }
}
