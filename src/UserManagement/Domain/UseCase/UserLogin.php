<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\DefaultUseCase;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\ValueObject\MatchPassword;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLogin extends DefaultUseCase
{    
    private $userLoginData;
    private $userRepository;
    private $passwordEncoder;
    private $userSessionManager;
    private $userEntity;

    public function __construct(
        $userLoginData = [], 
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder,
        UserSessionManager $userSessionManager

    ) {
        $this->userLoginData = $userLoginData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;

        $this->requiredFields = [
            'username' => 'Username',
            'password' => 'Password'
        ];
    }

    public function validate()
    {
        $this->validateRequiredFields($this->userLoginData);

        $this->validateUserCredentialsAndStatus();

        return $this;
    }

    private function validateUserCredentialsAndStatus()
    {
        $this->userEntity = $this->userRepository->getByUsername(
            new Username($this->userLoginData['username'])
        );
        
        $this->checkUserAccount();
        $this->checkUserCredentials();
        $this->checkUserStatus();
    }

    private function checkUserAccount()
    {
        if (! $this->userEntity) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function checkUserCredentials()
    {
        $matchPassword = new MatchPassword(
            $this->passwordEncoder, 
            $this->userEntity->getPassword(), 
            new Password($this->userLoginData['password'])
        );

        if (! $matchPassword->isMatch()) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function checkUserStatus()
    {
        if (! $this->userRepository->isApproved(new Username($this->userLoginData['username']))) {
            throw LoginFailedException::userStatusIsNotActive();
        }
    }

    public function perform()
    {
        $this->userSessionManager->set(
            $this->userSessionManager->getUserEntityAttributeName(), 
            $this->userEntity
        );
    }
}
