<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class UserLogin
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="string", length=255, name="ID", unique=true)
     */
    private $id;

    /**
     * @ORM\Id
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
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';

    public function __construct(UserName $userName, Password $password) 
    {
        $this->userName = $userName->get();
        $this->password = $password->get();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function isApproved(): bool
    {
        return ($this->status === User::STATUS_ACTIVE ? true : false);
    }
}
