<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\Service\UniqueIDResolver;
use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\Entity\UserRegistration;
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

class UserRegistrationAction implements UseCaseInterface
{
    private $userRegistrationData;
    private $userRegistrationRepository;
    private $passwordEncoder;
    private $uniqueIDResolver;

    private $userRegistrationEntity;

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
        $this->prepareUserRegistrationEntity();

        $this->validateConfirmationPassword();
        $this->validateUserNameExistence();

        $this->generateUniqueId();
        $this->generateSecuredPassword();
        
        $this->userRegistrationRepository->save($this->userRegistrationEntity);
    }

    private function prepareUserRegistrationEntity()
    {
        $this->userRegistrationEntity = new UserRegistration(
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
        $confirmPassword->isMatch($this->userRegistrationEntity->password());
    }

    private function validateUserNameExistence()
    {
        if ($this->userRegistrationRepository->isUserNameAlreadyRegistered($this->userRegistrationEntity->userName())) {
            throw RegistrationFailedException::userNameAlreadyRegistered();
        }
    }

    private function generateUniqueId()
    {
        $this->userRegistrationEntity->provideUniqueId(
            new UserId($this->uniqueIDResolver->generate())
        );
    }

    private function generateSecuredPassword()
    {
        $this->userRegistrationEntity->provideSecuredPassword(
            $this->passwordEncoder->encodePlainText(
                $this->userRegistrationEntity->password()
            )
        );
    }
}
