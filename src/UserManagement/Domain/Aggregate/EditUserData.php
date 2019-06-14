<?php

namespace UserManagement\Domain\Aggregate;

use UserManagement\Domain\ValueObject\Role;
use UserManagement\Domain\ValueObject\Status;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;

class EditUserData 
{
    public $firstName;
    public $lastName;
    public $status;
    public $role;

    public function __construct(
        FirstName $firstName, 
        LastName $lastName,
        Status $status,
        Role $role
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->status = $status;
        $this->role = $role;
    }
}
