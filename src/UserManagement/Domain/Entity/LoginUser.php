<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class LoginUser
{
    /**
     * @ORM\Column(type="text", name="UserName")
     */
    private $userName;

    /**
     * @ORM\Column(type="text", name="Password")
     */
    private $password;

    public function __construct(
        UserName $userName,
        Password $password
    ) {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function password(): string
    {
        return $this->password;
    }
}
