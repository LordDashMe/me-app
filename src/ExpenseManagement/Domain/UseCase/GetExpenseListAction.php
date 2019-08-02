<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Message\ExpenseDataTable;
use ExpenseManagement\Domain\Repository\ExpenseListRepository;

class GetExpenseListAction implements UseCaseInterface
{
    private $expenseDataTable;
    private $expenseListRepository;

    public function __construct(ExpenseDataTable $expenseDataTable, ExpenseListRepository $expenseListRepository) 
    {
        $this->expenseDataTable = $expenseDataTable;
        $this->expenseListRepository = $expenseListRepository;
    }

    public function perform()
    {
        $this->expenseListRepository->setUserId(new UserId($this->expenseDataTable->userId));
        
        $this->expenseListRepository->start($this->expenseDataTable->start);
        $this->expenseListRepository->length($this->expenseDataTable->length);
        $this->expenseListRepository->search($this->expenseDataTable->search);
        $this->expenseListRepository->orderColumn($this->expenseDataTable->orderColumn);
        $this->expenseListRepository->orderBy($this->expenseDataTable->orderBy);

        return $this->expenseListRepository->get();   
    }
}
