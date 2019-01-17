<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\MatchPassword;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLogin
{
    private $requiredFields = [
        'username' => 'Username',
        'password' => 'Password'
    ];

    private $loginData;
    private $userRepository;
    private $passwordEncoder;

    private $userEntity;

    public function __construct($loginData, UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->loginData = $loginData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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
            if (empty($this->loginData[$requiredField])) {
                throw LoginFailedException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }

        return $this;
    }

    private function validateUserCredentialsAndStatus()
    {
        $this->userEntity = $this->userRepository->getByUsername(
            new Username($this->loginData['username'])
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
            new Password($this->loginData['password'])
        );

        if (! $matchPassword->isMatch()) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function checkUserStatus()
    {
        if (! $this->userRepository->isApproved(new Username($this->loginData['username']))) {
            throw LoginFailedException::userStatusIsNotActive();
        }
    }

    public function execute()
    {
        return $this->userEntity;
    }
}
