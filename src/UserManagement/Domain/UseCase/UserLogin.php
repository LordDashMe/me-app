<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\MatchPassword;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLogin
{    
    private $userLoginData;
    private $userRepository;
    private $passwordEncoder;
    private $userSessionManager;

    private $requiredFields = [
        'username' => 'Username',
        'password' => 'Password'
    ];

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
    }

    public function validate()
    {
        $this->validateRequiredFields()
             ->validateUserCredentialsAndStatus();

        return $this;
    }

    private function validateRequiredFields()
    {
        foreach ($this->requiredFields as $requiredField => $requiedFieldLabel) {
            if (empty($this->userLoginData[$requiredField])) {
                throw LoginFailedException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }

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
        
        return $this;
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
            $this->userEntity->password(), 
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

    public function execute()
    {
        $this->userSessionManager->set(
            $this->userSessionManager->getUserEntityAttributeName(), 
            $this->userEntity
        );
    }
}
