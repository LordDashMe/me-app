<?php

namespace UserManagement\Domain\UseCase;

use Ramsey\Uuid\Uuid;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Aggregate\UserRegistrationData;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\ValueObject\Role;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Status;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\ConfirmPassword;

class UserRegistration implements UseCaseInterface
{
    private $userRegistrationData;
    private $userRepository;
    private $passwordEncoder;

    public function __construct(
        UserRegistrationData $userRegistrationData,
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder
    ) {
        $this->userRegistrationData = $userRegistrationData;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
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
        $this->userRegistrationData->firstName->required();
        $this->userRegistrationData->lastName->required();
        $this->userRegistrationData->email->required();
        $this->userRegistrationData->userName->required();
        $this->userRegistrationData->password->required();
        $this->userRegistrationData->confirmPassword->required();
    }

    private function validateEmail()
    {
        $this->userRegistrationData->email->validateFormat();
        $this->userRegistrationData->email->validateCharacterLength();
    }

    private function validateUserName()
    {
        $this->userRegistrationData->userName->validateCharacterLength();

        if ($this->userRepository->isRegistered($this->userRegistrationData->userName)) {
            throw RegistrationFailedException::userNameAlreadyRegistered();
        }
    }

    private function validatePassword()
    {
        $this->userRegistrationData->password->validateStandardFormat();
        $this->userRegistrationData->confirmPassword->validateIsMatch();
    }

    public function perform() 
    {   
        $this->generateSecurePassword();

        $this->userRepository->create(
            new User(
                new UserId(Uuid::uuid4()),
                $this->userRegistrationData->firstName,
                $this->userRegistrationData->lastName,
                $this->userRegistrationData->email,
                $this->userRegistrationData->userName,
                $this->userRegistrationData->password,
                new Status(),
                new Role(),
                new CreatedAt()
            )
        );
    }

    private function generateSecurePassword()
    {
        $currentPlainTextPassword = $this->userRegistrationData->password->get();

        $salt = uniqid() . '-salt';

        $this->userRegistrationData->password = new Password(
            $this->passwordEncoder->encodePlainText(
                $currentPlainTextPassword, $salt
            )
        );
    }
}
