<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\Service\UniqueIDResolver;
use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\Entity\RegisterUser;
use UserManagement\Domain\Exception\RegistrationFailedException;
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

class UserRegistration implements UseCaseInterface
{
    private $userRegistrationData;
    private $userRegistrationRepository;
    private $passwordEncoder;
    private $uniqueIDResolver;

    private $registerUserEntity;

    public function __construct(
        UserRegistrationData $userRegistrationData,
        UserRegistrationRepository $userRegistrationRepository, 
        PasswordEncoder $passwordEncoder,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->userRegistrationData = $userRegistrationData;
        $this->userRegistrationRepository = $userRegistrationRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->uniqueIDResolver = $uniqueIDResolver;
    }

    public function perform()
    {
        $this->prepareRegisterUserEntity();

        $this->validateConfirmationPassword();
        $this->validateUserNameExistence();

        $this->generateUniqueId();
        $this->generateSecuredPassword();
        
        $this->userRegistrationRepository->save($this->registerUserEntity);
    }

    private function prepareRegisterUserEntity()
    {
        $this->registerUserEntity = new RegisterUser(
            new FirstName($this->userRegistrationData->firstName),
            new LastName($this->userRegistrationData->lastName),
            new Email($this->userRegistrationData->email),
            new UserName($this->userRegistrationData->userName),
            new Password($this->userRegistrationData->password),
            new CreatedAt()
        );
    }

    private function validateConfirmationPassword()
    {
        $confirmPassword = new ConfirmPassword($this->userRegistrationData->confirmPassword);
        $confirmPassword->isMatch($this->registerUserEntity->password());
    }

    private function validateUserNameExistence()
    {
        if ($this->userRegistrationRepository->isUserNameAlreadyRegistered($this->registerUserEntity->userName())) {
            throw RegistrationFailedException::userNameAlreadyRegistered();
        }
    }

    private function generateUniqueId()
    {
        $this->registerUserEntity->provideUniqueId(
            new UserId($this->uniqueIDResolver->generate())
        );
    }

    private function generateSecuredPassword()
    {
        $salt = uniqid() . '-salt';

        $this->registerUserEntity->provideSecuredPassword(
            $this->passwordEncoder->encodePlainText(
                $this->registerUserEntity->password(), $salt
            )
        );
    }
}
