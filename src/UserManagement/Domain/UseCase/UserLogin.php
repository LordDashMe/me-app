<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Aggregate\UserLoginData;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\MatchPassword;

class UserLogin implements UseCaseInterface
{    
    private $userLoginData;
    private $userRepository;
    private $passwordEncoder;
    private $userSessionManager;

    private $userEntity;

    public function __construct(
        UserLoginData $userLoginData,
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder,
        UserSessionManager $userSessionManager
    ) {
        $this->userLoginData = $userLoginData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;
    }

    public function validate(): void
    {
        $this->userLoginData->userName->required();
        $this->userLoginData->password->required();

        $this->userEntity = $this->userRepository->getByUserName($this->userLoginData->userName);
        
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
            $this->userLoginData->password
        );

        if (! $matchPassword->isMatch()) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function validateUserStatus()
    {
        if (! $this->userRepository->isApproved($this->userLoginData->userName)) {
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
