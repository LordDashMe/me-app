<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\UseCase\ValidateRequireFields;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\UseCase\UserManage;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\UserManageFailedException;

class UserEdit extends UserManage implements UseCaseInterface
{
    private $requiredFields = [
        'first_name' => 'First Name',
        'last_name'  => 'Last Name'
    ];

    private $userId;
    private $userEditData = [];
    private $userRepository;

    public function __construct($userId, $userEditData, UserRepository $userRepository) 
    {
        $this->userId = $userId;
        $this->userEditData = $userEditData;
        $this->userRepository = $userRepository;
    }

    public function validate()
    {
        (new ValidateRequireFields($this->requiredFields, $this->userEditData))->perform();

        $this->validateUserIdIsNotEmpty($this->userId);

        return $this;
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
            new FirstName($this->userEditData['first_name']),
            new LastName($this->userEditData['last_name']),
            new Email($currentUserEntity->getEmail()),
            new Username($currentUserEntity->getUsername()),
            new Password($currentUserEntity->getPassword()),
            $this->evaluateUserStatus(),
            new CreatedAt($currentUserEntity->getCreatedAt())
        );  
    }

    private function evaluateUserStatus()
    {
        if ($this->userEditData['status'] === User::STATUS_ACTIVE) {
            return User::STATUS_ACTIVE;
        }

        return User::STATUS_INACTIVE;
    }

    private function getCurrentUserEntityUsingId()
    {
        return $this->userRepository->find(new UserId($this->userId));
    }
}
