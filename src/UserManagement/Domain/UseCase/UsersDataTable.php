<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\ValueObject\DataTable;

use UserManagement\Domain\Repository\UserRepository;

class UsersDataTable implements UseCaseInterface
{
    private $userDataTable;
    private $userRepository;

    public function __construct(DataTable $userDataTable, UserRepository $userRepository) 
    {
        $this->userDataTable = $userDataTable;
        $this->userRepository = $userRepository;
    }

    public function validate() {}

    public function perform()
    {
        return $this->userRepository->getDataTable($this->userDataTable);   
    }
}
