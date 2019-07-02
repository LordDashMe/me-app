<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\Message\DataTable;
use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Repository\UserListRepository;

class GetUserListAction implements UseCaseInterface
{
    private $dataTable;
    private $userListRepository;

    public function __construct(DataTable $dataTable, UserListRepository $userListRepository) 
    {
        $this->dataTable = $dataTable;
        $this->userListRepository = $userListRepository;
    }

    public function perform()
    {
        $this->userListRepository->start($this->dataTable->start);
        $this->userListRepository->length($this->dataTable->length);
        $this->userListRepository->search($this->dataTable->search);
        $this->userListRepository->orderColumn($this->dataTable->orderColumn);
        $this->userListRepository->orderBy($this->dataTable->orderBy);

        return $this->userListRepository->get();   
    }
}
