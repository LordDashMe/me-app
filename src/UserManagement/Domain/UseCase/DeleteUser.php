<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\ModifyUserRepository;
use UserManagement\Domain\ValueObject\UserId;

class DeleteUser implements UseCaseInterface
{
    private $deleteUserData;
    private $modifyUserRepository;

    public function __construct(DeleteUserData $deleteUserData, ModifyUserRepository $modifyUserRepository) 
    {
        $this->deleteUserData = $deleteUserData;
        $this->modifyUserRepository = $modifyUserRepository;
    }

    public function perform()
    {
        return $this->modifyUserRepository->softDelete(new UserId($this->deleteUserData->userId));      
    }
}
