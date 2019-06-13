<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\MatchPassword;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLogin implements UseCaseInterface
{    
    private $userName;
    private $password;

    private $userRepository;
    private $passwordEncoder;
    private $userSessionManager;

    private $userEntity;

    public function __construct(
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder,
        UserSessionManager $userSessionManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;
    }

    public function build(
        UserName $userName,
        Password $password
    ) {
        $this->userName = $userName;
        $this->password = $password;
    }

    public function validate()
    {
        $this->userName->required();
        $this->password->required();

        $this->userEntity = $this->userRepository->getByUserName($this->userName);
        
        $this->validateUserAccount();
        $this->validateUserCredentials();
        $this->validateUserStatus();
    }

    private function validateUserAccount()
    {
        if (! $this->userEntity) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function validateUserCredentials()
    {
        $matchPassword = new MatchPassword(
            $this->passwordEncoder, 
            $this->userEntity->getPassword(), 
            $this->password
        );

        if (! $matchPassword->isMatch()) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function validateUserStatus()
    {
        if (! $this->userRepository->isApproved($this->userName)) {
            throw LoginFailedException::userStatusIsNotActive();
        }
    }

    public function perform()
    {
        $this->userSessionManager->set(
            $this->userSessionManager->getUserEntitySessionName(), 
            $this->userEntity
        );
    }
}
