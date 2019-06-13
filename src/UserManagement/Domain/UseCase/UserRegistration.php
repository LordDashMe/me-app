<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;
use UserManagement\Domain\ValueObject\ConfirmPassword;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistration implements UseCaseInterface
{
    private $firstName;
    private $lastName;
    private $email;
    private $userName;
    private $password;
    private $confirmPassword;

    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoder $passwordEncoder) 
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function build(
        FirstName $firstName,
        LastName $lastName,
        Email $email,
        UserName $userName,
        Password $password,
        ConfirmPassword $confirmPassword
    ) {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->userName = $userName;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }

    public function validate()
    {
        $this->validateRequiredFields();
        $this->validateEmail();
        $this->validateUserName();
        $this->validatePassword();
    }

    private function validateRequiredFields()
    {
        $this->firstName->required();
        $this->lastName->required();
        $this->email->required();
        $this->userName->required();
        $this->password->required();
        $this->confirmPassword->required();
    }

    private function validateEmail()
    {
        $this->email->validateFormat();
        $this->email->validateCharacterLength();
    }

    private function validateUserName()
    {
        $this->userName->validateCharacterLength();

        if ($this->userRepository->isRegistered($this->userName)) {
            throw RegistrationFailedException::userNameAlreadyRegistered();
        }
    }

    private function validatePassword()
    {
        $this->password->validateStandardFormat();
        $this->confirmPassword->validateIsMatch();
    }

    public function perform() 
    {   
        $this->generateSecurePassword();

        $this->userRepository->create(
            new User(
                new UserId(),
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->userName,
                $this->password,
                new UserStatus(),
                new UserRole(),
                new CreatedAt()
            )
        );
    }

    private function generateSecurePassword()
    {
        $currentPlainTextPassword = $this->password->get();

        $salt = $currentPlainTextPassword . '-salt';

        $this->password = new Password(
            $this->passwordEncoder->encodePlainText(
                $currentPlainTextPassword, $salt
            )
        );
    }
}
