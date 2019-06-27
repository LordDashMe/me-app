<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\Message\DataTable;
use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Repository\UserDataTableRepository;

class UsersDataTable implements UseCaseInterface
{
    private $dataTable;
    private $userDataTableRepository;

    public function __construct(DataTable $dataTable, UserDataTableRepository $userDataTableRepository) 
    {
        $this->dataTable = $dataTable;
        $this->userDataTableRepository = $userDataTableRepository;
    }

    public function perform()
    {
        $this->userDataTableRepository->start($this->dataTable->start);
        $this->userDataTableRepository->length($this->dataTable->length);
        $this->userDataTableRepository->search($this->dataTable->search);
        $this->userDataTableRepository->orderColumn($this->dataTable->orderColumn);
        $this->userDataTableRepository->orderBy($this->dataTable->orderBy);

        return $this->userDataTableRepository->get();   
    }
}
