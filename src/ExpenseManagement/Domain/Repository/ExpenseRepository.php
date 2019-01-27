<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

interface ExpenseRepository
{
    public function create(Expense $expenseEntity);

    public function update(ExpenseId $expenseId, Expense $expenseEntity);

    public function find(ExpenseId $expenseId);

    public function getDataTable();

    public function softDelete(ExpenseId $expenseId);
}
