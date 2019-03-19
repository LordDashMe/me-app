<?php

namespace ExpenseManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class ExpensesDataTable implements UseCaseInterface
{
    private $dataTableOptionsDefault = [
        'start' => 0,
        'length' => 10,
        'search' => '',
        'orderColumn' => 'ID',
        'orderBy' => 'DESC'
    ];
    
    private $userId;
    private $expensesDataTableData;
    private $expenseRepository;

    public function __construct($userId, $expensesDataTableData, ExpenseRepository $expenseRepository) 
    {
        $this->userId = $userId;
        $this->expensesDataTableData = $this->mergeOptionsDefault($expensesDataTableData);
        $this->expenseRepository = $expenseRepository;
    }

    private function mergeOptionsDefault($expensesDataTableData)
    {
        return \array_merge($this->dataTableOptionsDefault, $expensesDataTableData);
    }

    public function validate() {}

    public function perform()
    {
        return $this->expenseRepository->getDataTable(
            new UserId($this->userId), 
            $this->expensesDataTableData
        );   
    }
}
