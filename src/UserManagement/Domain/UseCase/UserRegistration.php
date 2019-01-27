<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\ConfirmPassword;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistration
{
    private $userRegistrationData;
    private $userRepository;
    private $passwordEncoder;

    private $requiredFields = [
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'email' => 'Email',
        'username' => 'Username',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password'
    ];
    
    private $userEntity;

    public function __construct(
        $userRegistrationData = [], 
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder
    ) {
        $this->userRegistrationData = $userRegistrationData;
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
            if (empty($this->userRegistrationData[$requiredField])) {
                throw RegistrationFailedException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }

        return $this;
    }

    private function validateEmail()
    {
        $email = new Email($this->userRegistrationData['email']);

        if (! $email->isValid()) {
            throw RegistrationFailedException::invalidEmailFormat();
        }

        $this->userRegistrationData['email'] = $email;

        return $this;
    }

    private function validateUsername()
    {
        $username = new Username($this->userRegistrationData['username']);

        if ($this->userRepository->isRegistered($username)) {
            throw RegistrationFailedException::usernameAlreadyRegistered();
        }

        $this->userRegistrationData['username'] = $username;

        return $this;
    }

    private function validatePassword()
    {
        $password = new Password($this->userRegistrationData['password']);
        if (! $password->isValid()) {
            throw RegistrationFailedException::invalidPasswordFormat();
        }
        
        $confirmPassword = new ConfirmPassword(
            $password, $this->userRegistrationData['confirm_password']
        );
        if (! $confirmPassword->isEqual()) {
            throw RegistrationFailedException::confirmationPasswordNotMatched();
        }

        $this->securePasswordContent($password);

        return $this;
    }

    private function securePasswordContent($password)
    {
        $this->userRegistrationData['password'] = new Password(
            $this->passwordEncoder->encodePlainText($password->get(), $password->get())
        );
    }

    private function buildUserEntity()
    {
        $this->userEntity = new User(
            new UserId(),
            $this->userRegistrationData['first_name'],
            $this->userRegistrationData['last_name'],
            $this->userRegistrationData['email'],
            $this->userRegistrationData['username'],
            $this->userRegistrationData['password'],
            User::STATUS_INACTIVE,
            new CreatedAt()
        );
    }

    public function execute() 
    {
        return $this->userRepository->create($this->userEntity);
    }
}
