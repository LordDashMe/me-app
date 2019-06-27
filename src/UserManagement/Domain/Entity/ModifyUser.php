<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class ModifyUser
{
    /**
     * @ORM\Column(type="text", name="FirstName")
     */
    private $firstName;

    /**
     * @ORM\Column(type="text", name="LastName")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", name="Email")
     */
    private $email;

    /**
     * @ORM\Column(type="smallint", name="Status", options={"comment":"1 = Active | 2 = Inactive"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';


    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function deletedAt(): string
    {
        return $this->deletedAt;
    }

    public function changeFirstName(FirstName $firstName)
    {
        $this->firstName = $firstName;
    }

    public function changeLastName(LastName $lastName)
    {
        $this->lastName = $lastName;
    }

    public function changeEmail(Email $email)
    {
        $this->email = $email;
    }

    public function changeStatus(string $status)
    {
        $this->status = $status;
    }
    
    public function delete(CreatedAt $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}
