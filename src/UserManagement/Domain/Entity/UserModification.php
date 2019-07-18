<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\Status;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class UserModification
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="text", name="ID", unique=true)
     */
    private $id;

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

    public function __construct(UserId $userId)
    {
        $this->id = $userId->get();
    }

    public function id(): string 
    {
        return $this->id;
    }

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

    public function changeFirstName(FirstName $firstName): void
    {
        $this->firstName = $firstName->get();
    }

    public function changeLastName(LastName $lastName): void
    {
        $this->lastName = $lastName->get();
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email->get();
    }

    public function changeStatus(Status $status): void
    {
        $this->status = $status->get();
    }
}
