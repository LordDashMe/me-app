<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\Status;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class UserRegistration
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
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
     * @ORM\Column(type="text", name="UserName")
     */
    private $userName;

    /**
     * @ORM\Column(type="text", name="Password")
     */
    private $password;

    /**
     * @ORM\Column(type="smallint", name="Status", options={"comment":"1 = Active | 2 = Inactive"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", name="CreatedAt")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';

    public function __construct(
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $userName,
        Password $password,
        CreatedAt $createdAt
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;
        $this->createdAt = $createdAt;
        
        $this->status = $this->provideDefaultStatus();
    }

    private function provideDefaultStatus(): string
    {
        return User::STATUS_INACTIVE;
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

    public function userName(): string
    {
        return $this->userName;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    public function provideUniqueId(UserId $userId): void
    {
        $this->id = $userId;
    }

    public function provideSecuredPassword(string $securedPassword): void
    {
        $this->password = $securedPassword;
    }
}
