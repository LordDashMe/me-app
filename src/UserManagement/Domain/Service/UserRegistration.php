<?php

namespace UserManagement\Domain\Service;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Excetion\RegistrationFailedException;

class UserRegistration
{
    private $username;
    private $password;
    private $firstname;
    private $lastname;

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function withUsername($username)
    {
        $this->username = new Username($username);

        return $this;
    }

    public function withPassword($password)
    {
        $password = new Password($password);

        if ($password->isInvalidFormat()) {
            throw RegistrationFailedException::invalidPasswordFormatted();
        }

        $this->password = $password;

        return $this;
    }

    public function withFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function withLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function execute() 
    {
        return $this->userRepository->create(
            $this->buildUserEntity()
        );
    }
    
    private function buildUserEntity()
    {
        $userEntity = new User();

        $userEntity->setUsername($this->username);
        $userEntity->setPassword($this->password);
        $userEntity->setFirstname($this->firstname);
        $userEntity->setLastname($this->lastname);

        return $userEntity;
    }
}
