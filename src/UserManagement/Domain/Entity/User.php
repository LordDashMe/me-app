<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;
use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * @ORM\Id
     * @ORM\Column(type="guid", name="id")
     */
    private $id;

    /**
     * @ORM\Column(type="text", name="first_name")
     */
    private $firstName;

    /**
     * @ORM\Column(type="text", name="last_name")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", name="email")
     */
    private $email;

    /**
     * @ORM\Column(type="text", name="username")
     */
    private $username;

    /**
     * @ORM\Column(type="text", name="password")
     */
    private $password;

    /**
     * @ORM\Column(type="smallint", name="status", options={"comment":"1 = Active | 2 = Inactive"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", name="created_at")
     */
    private $createdAt;

    public function __construct(
        UserId $id,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $username,
        Password $password,
        $status = self::STATUS_INACTIVE,
        CreatedAt $createdAt
    ) {
        $this->id = $id->get();
        $this->firstName = $firstName->get();
        $this->lastName = $lastName->get();
        $this->email = $email->get();
        $this->username = $username->get();
        $this->password = $password->get();
        $this->status = $status;
        $this->createdAt = $createdAt->get();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
