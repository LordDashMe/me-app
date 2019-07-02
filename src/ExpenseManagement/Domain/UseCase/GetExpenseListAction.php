<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\Message\DataTable;
use AppCommon\Domain\UseCase\UseCaseInterface;

use ExpenseManagement\Domain\Repository\ExpenseListRepository;

class GetExpenseListAction implements UseCaseInterface
{
    private $dataTable;
    private $expenseListRepository;

    public function __construct(DataTable $dataTable, ExpenseListRepository $expenseListRepository) 
    {
        $this->dataTable = $dataTable;
        $this->expenseListRepository = $expenseListRepository;
    }

    public function perform()
    {
        $this->expenseListRepository->start($this->dataTable->start);
        $this->expenseListRepository->length($this->dataTable->length);
        $this->expenseListRepository->search($this->dataTable->search);
        $this->expenseListRepository->orderColumn($this->dataTable->orderColumn);
        $this->expenseListRepository->orderBy($this->dataTable->orderBy);

        return $this->expenseListRepository->get();   
    }
}
