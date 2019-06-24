<?php

namespace UserManagement\Application\Command\Handler;

use DomainCommon\Application\Command\Handler\CommandHandler;
use DomainCommon\Domain\Service\UniqueIDResolver;
use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\Repository\UserRegistrationRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\ConfirmPassword;
use UserManagement\Domain\ValueObject\Status;

use UserManagement\Application\Command\UserRegistrationCommand;

class UserRegistrationCommandHandler implements CommandHandler
{
    private $command;
    private $repository;
    private $passwordEncoder;
    private $uniqueIDResolver;

    public function __construct(
        UserRegistrationCommand $command,
        UserRegistrationRepository $repository, 
        PasswordEncoder $passwordEncoder,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->command = $command;
        $this->repository = $repository;
        $this->passwordEncoder = $passwordEncoder;
        $this->uniqueIDResolver = $uniqueIDResolver;
    }

    public function handle(): void
    {
        $this->validateConfirmPassword();

        $email = $this->validateEmail();
        $userName = $this->validateUserName();
        $password = $this->validatePassword();

        $entity = new UserRegistration(
            new UserId($uniqueIDResolver->generate()),
            new FirstName($this->command->firstName()),
            new LastName($this->command->lastName()),
            $email,
            $userName,
            $this->generateSecurePassword($password),
            new CreatedAt()
        );
        
        $entity->validateUsernameExistence($this->repository);

        $this->repository->save($entity);
    }

    private function validateConfirmPassword()
    {
        $confirmPassword = new ConfirmPassword(
            $this->command->password(), 
            $this->command->confirmPassword()
        );
        $confirmPassword->validateIsMatch();

        return $confirmPassword;
    }

    private function validateEmail()
    {
        $email = new Email($this->command->email());
        $email->validateCharacterLength();

        return $email;
    }

    private function validateUserName()
    {
        $userName = new UserName($this->command->userName());
        $userName->validateCharacterLength();

        return $userName;
    }

    private function validatePassword()
    {
        $password = new Password($this->command->password());
        $password->validateStandardFormat();

        return $password;
    }

    private function generateSecurePassword($password)
    {
        $salt = uniqid() . '-salt';
        return $this->passwordEncoder->encodePlainText($password, $salt);
    }
}
