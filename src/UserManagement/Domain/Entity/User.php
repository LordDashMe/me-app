<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\CreatedAt;

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
        $status,
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

    public function id()
    {
        return $this->id;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function email()
    {
        return $this->email;
    }

    public function username()
    {
        return $this->username;
    }

    public function password()
    {
        return $this->password;
    }

    public function status()
    {
        return $this->status;
    }

    public function createAt()
    {
        return $this->createAt;
    }
}
