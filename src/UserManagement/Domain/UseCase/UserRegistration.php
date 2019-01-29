<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\DefaultUseCase;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\ValueObject\ConfirmPassword;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistration extends DefaultUseCase
{
    private $userRegistrationData = [];
    private $userRepository;
    private $passwordEncoder;

    public function __construct(
        $userRegistrationData, 
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder
    ) {
        $this->userRegistrationData = $userRegistrationData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;

        $this->requiredFields = [
            'first_name'       => 'First Name',
            'last_name'        => 'Last Name',
            'email'            => 'Email',
            'username'         => 'Username',
            'password'         => 'Password',
            'confirm_password' => 'Confirm Password'
        ];
    }

    public function validate()
    {
        $this->validateRequiredFields($this->userRegistrationData);

        $this->validateEmail();
        $this->validateUsername();
        $this->validatePassword();

        return $this;
    }

    private function validateEmail()
    {
        $email = new Email($this->userRegistrationData['email']);

        if (! $email->isValid()) {
            throw RegistrationFailedException::invalidEmailFormat();
        }

        $this->userRegistrationData['email'] = $email;
    }

    private function validateUsername()
    {
        $username = new Username($this->userRegistrationData['username']);

        if ($this->userRepository->isRegistered($username)) {
            throw RegistrationFailedException::usernameAlreadyRegistered();
        }

        $this->userRegistrationData['username'] = $username;
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

        $this->generateSecurePasswordContent($password);
    }

    private function generateSecurePasswordContent($password)
    {
        $salt = $password->get();

        $this->userRegistrationData['password'] = new Password(
            $this->passwordEncoder->encodePlainText($password->get(), $salt)
        );
    }

    public function perform() 
    {
        $this->userRepository->create($this->composeUserEntity());
    }

    private function composeUserEntity()
    {
        return new User(
            new UserId(),
            new FirstName($this->userRegistrationData['first_name']),
            new LastName($this->userRegistrationData['last_name']),
            $this->userRegistrationData['email'],
            $this->userRegistrationData['username'],
            $this->userRegistrationData['password'],
            User::STATUS_INACTIVE,
            new CreatedAt()
        );
    }
}
