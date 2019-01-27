<?php

namespace ExpenseManagement\Infrastructure\Repository\Doctrine;

use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class ExpenseRepositoryImpl implements ExpenseRepository
{
    public function __construct()
    {

    }

    public function create(Expense $expenseEntity)
    {

    }

    public function update(ExpenseId $expenseId, Expense $expenseEntity)
    {
        
    }

    public function find(ExpenseId $expenseId)
    {

    }

    public function getDataTable()
    {

    }

    public function softDelete(ExpenseId $expenseId)
    {

    }
}
