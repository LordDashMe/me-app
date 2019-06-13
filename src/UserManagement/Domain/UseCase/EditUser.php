<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\UseCase\ValidateRequireFields;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\UseCase\ManageUser;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\ManageUserFailedException;

class EditUser extends ManageUser implements UseCaseInterface
{
    private $requiredFields = [
        'firstName' => 'First Name',
        'lastName' => 'Last Name'
    ];

    private $userId;
    private $editUserData = [];
    private $userRepository;

    public function __construct($userId, $editUserData, UserRepository $userRepository) 
    {
        $this->userId = $userId;
        $this->editUserData = $editUserData;
        $this->userRepository = $userRepository;
    }

    public function validate()
    {
        (new ValidateRequireFields($this->requiredFields, $this->editUserData))->perform();

        $this->validateUserIdIsNotEmpty($this->userId);
    }

    public function perform()
    {
        return $this->userRepository->update($this->composeUserEntity());
    }

    private function composeUserEntity()
    {
        $currentUserEntity = $this->getCurrentUserEntityUsingId();

        return new User(
            new UserId($this->userId),
            new FirstName($this->editUserData['firstName']),
            new LastName($this->editUserData['lastName']),
            new Email($currentUserEntity->getEmail()),
            new UserName($currentUserEntity->getUserName()),
            new Password($currentUserEntity->getPassword()),
            new UserStatus($this->editUserData['status']),
            new UserRole($this->editUserData['role']),
            new CreatedAt($currentUserEntity->getCreatedAt())
        );  
    }

    private function getCurrentUserEntityUsingId()
    {
        return $this->userRepository->get(new UserId($this->userId));
    }
}
