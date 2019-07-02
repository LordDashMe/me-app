<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Entity\UserDeletion;
use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\UserDeletionRepository;
use UserManagement\Domain\ValueObject\UserId;

class DeleteUserAction implements UseCaseInterface
{
    private $deleteUserData;
    private $userDeletionRepository;

    public function __construct(
        DeleteUserData $deleteUserData, 
        UserDeletionRepository $userDeletionRepository
    ) {
        $this->deleteUserData = $deleteUserData;
        $this->userDeletionRepository = $userDeletionRepository;
    }

    public function perform()
    {
        return $this->userDeletionRepository->save(
            new UserDeletion(new UserId($this->deleteUserData->userId))
        );      
    }
}
