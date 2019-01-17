<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\ConfirmPassword;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistration
{
    private $requiredFields = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
        'username' => 'Username',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password'
    ];

    private $userData;
    private $userRepository;
    private $passwordEncoder;
    
    private $userEntity;

    public function __construct($userData = [], UserRepository $userRepository, PasswordEncoder $passwordEncoder) 
    {
        $this->userData = $userData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function validate()
    {
        $this->validateRequiredFields()
             ->validateEmail()
             ->validateUsername()
             ->validatePassword();

        $this->buildUserEntity();

        return $this;
    }

    private function validateRequiredFields()
    {
        foreach ($this->requiredFields as $requiredField => $requiedFieldLabel) {
            if (empty($this->userData[$requiredField])) {
                throw RegistrationFailedException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }

        return $this;
    }

    private function validateEmail()
    {
        $email = new Email($this->userData['email']);

        if (! $email->isValid()) {
            throw RegistrationFailedException::invalidEmailFormat();
        }

        $this->userData['email'] = $email;

        return $this;
    }

    private function validateUsername()
    {
        $username = new Username($this->userData['username']);

        if ($this->userRepository->isRegistered($username)) {
            throw RegistrationFailedException::usernameAlreadyRegistered();
        }

        $this->userData['username'] = $username;

        return $this;
    }

    private function validatePassword()
    {
        $password = new Password($this->userData['password']);

        if (! $password->isValid()) {
            throw RegistrationFailedException::invalidPasswordFormat();
        }
        
        $confirmPassword = new ConfirmPassword(
            $password, $this->userData['confirm_password']
        );

        if (! $confirmPassword->isEqual()) {
            throw RegistrationFailedException::confirmationPasswordNotMatched();
        }

        $this->securePasswordContent($password);

        return $this;
    }

    private function securePasswordContent($password)
    {
        $this->userData['password'] = new Password(
            $this->passwordEncoder->encodePlainText($password->get())
        );
    }

    private function buildUserEntity()
    {
        $this->userEntity = new User(
            new UserId(),
            $this->userData['first_name'],
            $this->userData['last_name'],
            $this->userData['email'],
            $this->userData['username'],
            $this->userData['password'],
            User::STATUS_INACTIVE,
            new CreatedAt()
        );
    }

    public function execute() 
    {
        return $this->userRepository->create(
            $this->userEntity
        );
    }
}
