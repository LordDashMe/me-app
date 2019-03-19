<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use UserManagement\Domain\UseCase\ManageUser;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\ManageUserFailedException;

class DeleteUser extends ManageUser implements UseCaseInterface
{
    private $userId;
    private $userRepository;

    public function __construct($userId, UserRepository $userRepository) 
    {
        $this->userId = $userId;
        $this->userRepository = $userRepository;
    }

    public function validate()
    {
        $this->validateUserIdIsNotEmpty($this->userId);

        return $this;
    }

    public function perform()
    {
        return $this->userRepository->softDelete(new UserId($this->userId));      
    }
}
