<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\ModifyUser;
use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Repository\ModifyUserRepository;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;

class EditUser implements UseCaseInterface
{
    private $editUserData;
    private $modifyUserRepository;

    public function __construct(
        EditUserData $editUserData,
        ModifyUserRepository $modifyUserRepository
    ) {
        $this->editUserData = $editUserData;
        $this->modifyUserRepository = $modifyUserRepository;
    }

    public function perform()
    {
        $modifyUserEntity = new ModifyUser(
            new UserId($this->editUserData->userId)
        );
        
        $modifyUserEntity->changeFirstName(new FirstName($this->editUserData->firstName));
        $modifyUserEntity->changeLastName(new LastName($this->editUserData->lastName));
        $modifyUserEntity->changeEmail(new Email($this->editUserData->email));
        $modifyUserEntity->changeStatus($this->editUserData->status);

        return $this->modifyUserRepository->save($modifyUserEntity);
    }
}
