<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\ValueObject\UserId;

class DeleteUserAction implements UseCaseInterface
{
    private $deleteUserData;
    private $userModificationRepository;

    public function __construct(
        DeleteUserData $deleteUserData, 
        UserModificationRepository $userModificationRepository
    ) {
        $this->deleteUserData = $deleteUserData;
        $this->userModificationRepository = $userModificationRepository;
    }

    public function perform()
    {
        return $this->userModificationRepository->softDelete(
            new UserId($this->deleteUserData->userId)
        );      
    }
}
