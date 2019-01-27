<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;

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
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $firstName;

    /**
     * @ORM\Column(type="text")
     */
    private $lastName;

    /**
     * @ORM\Column(type="text")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="smallint", options={"comment":"1 = Active | 2 = Inactive"})
     */
    private $status;

    /**
     * @ORM\Column(type="string")
     */
    private $createdAt;

    public function __construct(
        UserId $id,
        $firstName,
        $lastName,
        Email $email,
        UserName $username,
        Password $password,
        $status = self::STATUS_INACTIVE,
        CreatedAt $createdAt
    ) {
        $this->id = $id->get();
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
