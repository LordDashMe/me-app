<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\UseCase\ValidateRequireFields;
use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Aggregate\EditUserData;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Exception\ManageUserFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\UseCase\ManageUser;
use UserManagement\Domain\ValueObject\UserId;

class EditUser extends ManageUser implements UseCaseInterface
{
    private $userId;
    private $editUserData;
    private $userRepository;

    public function __construct(
        UserId $userId, 
        EditUserData $editUserData, 
        UserRepository $userRepository
    ) {
        $this->userId = $userId;
        $this->editUserData = $editUserData;
        $this->userRepository = $userRepository;
    }

    public function validate(): void
    {
        $this->editUserData->firstName->required();
        $this->editUserData->lastName->required();

        $this->validateUserIdIsNotEmpty($this->userId);
    }

    public function perform()
    {
        $currentUserEntity = $this->getCurrentUserEntityUsingId();

        $currentUserEntity->setFirstName($this->editUserData->firstName);
        $currentUserEntity->setLastName($this->editUserData->lastName);
        $currentUserEntity->setStatus($this->editUserData->status);
        $currentUserEntity->setRole($this->editUserData->role);

        return $this->userRepository->update($currentUserEntity);
    }

    private function getCurrentUserEntityUsingId()
    {
        return $this->userRepository->get($this->userId);
    }
}
