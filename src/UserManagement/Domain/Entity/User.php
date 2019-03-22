<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;

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
     * @ORM\Id
     * @ORM\Column(type="integer", name="ID", unique=true)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     *
     * @ORM\Column(type="uuid", name="UUID", unique=true)
     */
    protected $uuid;

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
     * @ORM\Column(type="text", name="Username")
     */
    private $username;

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
        UserId $id,
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $username,
        Password $password,
        UserStatus $status,
        UserRole $role,
        CreatedAt $createdAt
    ) {
        // $this->id = $id->get();
        $this->uuid = \Ramsey\Uuid\Uuid::uuid4();
        $this->firstName = $firstName->get();
        $this->lastName = $lastName->get();
        $this->email = $email->get();
        $this->username = $username->get();
        $this->password = $password->get();
        $this->status = $status->get();
        $this->role = $role->get();
        $this->createdAt = $createdAt->get();
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUuid()
    {
        return $this->uuid;
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

    public function getRole()
    {
        return $this->role;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
