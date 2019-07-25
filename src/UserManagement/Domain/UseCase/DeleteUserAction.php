<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

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
        $entity = new UserDeletion(new UserId($this->deleteUserData->userId));
        $entity->softDelete(new CreatedAt());

        return $this->userDeletionRepository->save($entity);      
    }
}
