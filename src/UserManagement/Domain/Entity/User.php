<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\Role;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Status;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '2';
    
    const ROLE_ADMIN = '1';
    const ROLE_EDITOR = '2';
    const ROLE_MEMBER = '3';

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
     * @ORM\Column(type="smallint", name="Role", options={"comment":"1 = Admin | 2 = Editor | 3 = Member"})
     */
    private $role;

    /**
     * @ORM\Column(type="string", name="CreatedAt")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';

    public function __construct(
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $userName,
        Password $password,
        Status $status,
        Role $role,
        CreatedAt $createdAt
    ) {
        $this->setId($userId);
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
        $this->setEmail($email);
        $this->setUserName($userName);
        $this->setPassword($password);
        $this->setStatus($status);
        $this->setRole($role);
        $this->setCreatedAt($createdAt);
    }

    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function setId(UserId $userId): void
    {
        $this->id = $userId->get();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setFirstName(FirstName $firstName): void
    {
        $this->firstName = $firstName->get();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setLastName(LastName $lastName): void
    {
        $this->lastName = $lastName->get();
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setEmail(Email $email): void 
    {
        $this->email = $email->get();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setUserName(UserName $userName): void
    {
        $this->userName = $userName->get();
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password->get();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status->get();
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role->get();
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setCreatedAt(CreatedAt $createdAt): void
    {
        $this->createdAt = $createdAt->get();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}
