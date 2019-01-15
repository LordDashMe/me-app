<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="text")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    public function setUsername(Username $username) 
    {
        $this->username = $username->get();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword(Password $password)
    {
        $this->password = $password->get();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
}
