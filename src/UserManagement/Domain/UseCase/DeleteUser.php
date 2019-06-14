<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Exception\ManageUserFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\UseCase\ManageUser;
use UserManagement\Domain\ValueObject\UserId;

class DeleteUser extends ManageUser implements UseCaseInterface
{
    private $userId;
    private $userRepository;

    public function __construct(UserId $userId, UserRepository $userRepository) 
    {
        $this->userId = $userId;
        $this->userRepository = $userRepository;
    }

    public function validate()
    {
        $this->validateUserIdIsNotEmpty($this->userId);
    }

    public function perform()
    {
        return $this->userRepository->softDelete($this->userId);      
    }
}
