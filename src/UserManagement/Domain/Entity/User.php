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
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    
    const ROLE_ADMIN = 1;
    const ROLE_EDITOR = 2;
    const ROLE_MEMBER = 3;

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

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function setId(UserId $userId)
    {
        $this->id = $userId->get();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstName(FirstName $firstName)
    {
        $this->firstName = $firstName->get();
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName(LastName $lastName)
    {
        $this->lastName = $lastName->get();
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setEmail(Email $email) 
    {
        $this->email = $email->get();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUserName(UserName $userName)
    {
        $this->userName = $userName->get();
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setPassword(Password $password)
    {
        $this->password = $password->get();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setStatus(Status $status)
    {
        $this->status = $status->get();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setRole(Role $role)
    {
        $this->role = $role->get();
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setCreatedAt(CreatedAt $createdAt)
    {
        $this->createdAt = $createdAt->get();
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
