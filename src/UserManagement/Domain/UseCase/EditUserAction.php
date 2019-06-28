<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\UserModification;
use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;

class EditUserAction implements UseCaseInterface
{
    private $editUserData;
    private $userModificationRepository;

    public function __construct(
        EditUserData $editUserData,
        UserModificationRepository $userModificationRepository
    ) {
        $this->editUserData = $editUserData;
        $this->userModificationRepository = $userModificationRepository;
    }

    public function perform()
    {
        $modifyUserEntity = new UserModification(
            new UserId($this->editUserData->userId)
        );
        
        $modifyUserEntity->changeFirstName(new FirstName($this->editUserData->firstName));
        $modifyUserEntity->changeLastName(new LastName($this->editUserData->lastName));
        $modifyUserEntity->changeEmail(new Email($this->editUserData->email));
        $modifyUserEntity->changeStatus($this->editUserData->status);

        return $this->userModificationRepository->save($modifyUserEntity);
    }
}
