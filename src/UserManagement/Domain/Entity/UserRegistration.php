<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Repository\UserRegistrationRepository;
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

    private $repository;

    public function __construct(
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $userName,
        Password $password,
        CreatedAt $createdAt
    ) {
        $this->id = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;
        $this->status = $this->defaultStatus();
        $this->createdAt = $createdAt;
    }

    private function defaultStatus()
    {
        return User::STATUS_INACTIVE;
    }

    public function validateUsernameExistence(UserRegistrationRepository $repository)
    {
        if ($repository->isRegistered($this->userName)) {
            throw RegistrationFailedException::userNameAlreadyRegistered();
        }
    }
}
